<?php

namespace Phine\Handlers;

use LINE\Webhook\Model\MessageEvent;
use LINE\Webhook\Model\TextMessageContent;

abstract class BaseCommandHandler extends BaseEventHandler
{
    public const EVENT_CLASS = MessageEvent::class;
    public const MESSAGE_TYPE_CLASS = TextMessageContent::class;

    /**
     * In the case of TextMessageEvent, execution control can be applied by enumerating the string to be responded to.
     *
     * @return string[]
     */
    abstract public static function commands(): array;

    /**
     * Whether command arguments are accepted or not.
     */
    public static function isPrefix(): bool
    {
        return false;
    }
}
