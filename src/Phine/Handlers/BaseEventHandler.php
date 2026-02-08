<?php

namespace Phine\Handlers;

use LINE\Webhook\Model\MessageEvent;
use Phine\Exceptions\NoDefinedException;

/**
 * Base class for event handlers.
 */
abstract class BaseEventHandler implements EventHandlerInterface
{
    /** @var array<string, static> */
    private static array $instances = [];

    /**
     * Constructor is final to ensure getInstance() works correctly.
     * Child classes should not override this constructor.
     */
    final public function __construct() {}

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
            throw new NoDefinedException('EVENT_CLASS constant not defined in handler.');
        }

        return $t;
    }

    public static function getMessageContentClass(): string
    {
        $eventClass = static::getEventClass();

        if ($eventClass !== MessageEvent::class) {
            return '';
        }

        $t = static::MESSAGE_TYPE_CLASS;

        if ($t === '') {
            throw new NoDefinedException('MESSAGE_TYPE_CLASS constant not defined in message event handler.');
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
            throw new NoDefinedException('MESSAGE_SOURCE_CLASS constant not defined in message event handler.');
        }

        return $t;
    }
}
