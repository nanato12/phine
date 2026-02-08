<?php

namespace Phine\Handlers;

use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\MessageEvent;
use Phine\Client;
use Phine\Exceptions\NoDefinedException;

interface EventHandler
{
    public const EVENT_CLASS = '';
    public const MESSAGE_TYPE_CLASS = '';
    public const MESSAGE_SOURCE_CLASS = 'all';

    /**
     * @param Client $client Phine Client
     * @param Event  $event  webhook event
     * */
    public function handle(Client $client, Event $event): void;

    /**
     * This is the static method that controls the access to the singleton instance.
     */
    public static function getInstance(): static;

    public static function getEventClass(): string;

    public static function getMessageContentClass(): string;

    public static function getMessageSourceClass(): string;
}

abstract class BaseEventHandler implements EventHandler
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
