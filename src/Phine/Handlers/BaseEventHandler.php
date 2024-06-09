<?php

namespace Phine\Handlers;

use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\MessageEvent;
use Phine\Exceptions\NoDifinedException;

interface EventHandler
{
    public const EVENT_CLASS = '';
    public const MESSAGE_TYPE_CLASS = '';
    public const MESSAGE_SOURCE_CLASS = 'all';

    /** @param Event $event webhook event */
    public function handle($event): void;

    /**
     * This is the static method that controls the access to the singleton instance.
     */
    public static function getInstance(): static;

    public static function getEventClass(): string;

    public static function getMessageTypeClass(): string;

    public static function getMessageSourceClass(): string;
}

abstract class BaseEventHandler implements EventHandler
{
    /** @var array<string, static> */
    private static $instances = [];

    public static function getInstance(): static
    {
        $cls = static::class;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public static function getEventClass(): string
    {
        $t = static::EVENT_CLASS;

        if ($t === '') {
            throw new NoDifinedException('EVENT_CLASS constant not defined in handler.');
        }

        return $t;
    }

    public static function getMessageTypeClass(): string
    {
        $eventClass = static::getEventClass();

        if ($eventClass !== MessageEvent::class) {
            return '';
        }

        $t = static::MESSAGE_TYPE_CLASS;

        if ($t === '') {
            throw new NoDifinedException('MESSAGE_TYPE_CLASS constant not defined in message event handler.');
        }

        return $t;
    }

    public static function getMessageSourceClass(): string
    {
        $eventClass = static::getEventClass();

        if ($eventClass !== MessageEvent::class) {
            return '';
        }

        $t = static::MESSAGE_SOURCE_CLASS;

        if ($t === '') {
            throw new NoDifinedException('MESSAGE_SOURCE_CLASS constant not defined in message event handler.');
        }

        return $t;
    }
}
