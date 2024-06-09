<?php

namespace Phine\Handlers;

use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\MessageEvent;

/**
 * Function to return a predefined class array that inherits the class or instance of the argument.
 *
 * @param object|string $class class or instance object
 *
 * @return string[] class array
 */
function getSubClasses(object|string $class): array
{
    return array_values(
        array_filter(
            get_declared_classes(),
            function (string $c) use ($class): bool {
                return is_subclass_of($c, is_string($class) ? $class : $class::class);
            }
        )
    );
}

class EventDispatcher
{
    public function dispatch(Event $event): void
    {
        /** @var BaseEventHandler[] $handlers */
        $handlers = getSubClasses(BaseEventHandler::class);

        foreach ($handlers as $handler) {
            if ($handler::getEventClass() !== $event::class) {
                continue;
            }

            if ($event instanceof MessageEvent && $event->getMessage()::class !== $handler->getMessageTypeClass()) {
                continue;
            }
            $h = $handler::getInstance();
            $h->handle($event);
        }
    }
}
