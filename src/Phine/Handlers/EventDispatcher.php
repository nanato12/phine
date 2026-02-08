<?php

namespace Phine\Handlers;

use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\MessageEvent;
use LINE\Webhook\Model\TextMessageContent;
use Phine\Client;
use Phine\Exceptions\InvalidHandlerClassException;

abstract class EventDispatcher
{
    /**
     * Constructor is final to ensure dispatch() works correctly.
     * Child classes should not override this constructor.
     */
    final public function __construct() {}

    public static function dispatch(Client $client, Event $event): void
    {
        $handlers = (new static())->getHandlerClasses();

        foreach ($handlers as $handler) {
            if (!is_subclass_of($handler, BaseEventHandler::class)) {
                throw new InvalidHandlerClassException(
                    sprintf("'%s' is not a class that extends BaseEventHandler.", $handler)
                );
            }

            /** @var BaseEventHandler $handler */
            if ($handler::getEventClass() !== $event::class) {
                continue;
            }

            if (
                $event instanceof MessageEvent
                && $event->getMessage()::class !== $handler::getMessageContentClass()
            ) {
                continue;
            }

            if (
                ($sourceClass = $handler::getMessageSourceClass())
                && $sourceClass != 'all'
                && !is_null($source = $event->getSource())
                && $sourceClass !== $source::class
            ) {
                continue;
            }

            if (
                is_subclass_of($handler, BaseCommandHandler::class)
                && $event instanceof MessageEvent
            ) {
                $content = $event->getMessage();

                if ($content instanceof TextMessageContent) {
                    /** @var BaseCommandHandler $handler */
                    if ($handler::isPrefix()) {
                        if (
                            empty(array_filter($handler::commands(), function ($s) use ($content) {
                                return strpos($content->getText(), $s) === 0;
                            }))
                        ) {
                            continue;
                        }
                    } elseif (!in_array($content->getText(), $handler::commands(), true)) {
                        continue;
                    }
                }
            }

            $client->setEvent($event);
            $h = $handler::getInstance();
            $h->handle($client, $event);
        }
    }

    /**
     * return handler classes.
     *
     * @return string[]
     */
    abstract public function getHandlerClasses(): array;
}
