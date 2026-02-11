<?php

namespace Phine\Handlers;

use LINE\Webhook\Model\Event;
use Phine\Client;

/**
 * Interface for event handlers.
 */
interface EventHandlerInterface
{
    public const EVENT_CLASS = '';
    public const MESSAGE_TYPE_CLASS = '';
    public const MESSAGE_SOURCE_CLASS = 'all';

    /**
     * Handle the event.
     *
     * @param Client $client Phine Client
     * @param Event  $event  webhook event
     */
    public function handle(Client $client, Event $event): void;

    /**
     * Get the singleton instance of this handler.
     */
    public static function getInstance(): static;

    /**
     * Get the event class this handler responds to.
     */
    public static function getEventClass(): string;

    /**
     * Get the message content class this handler responds to (for MessageEvent).
     */
    public static function getMessageContentClass(): string;

    /**
     * Get the message source class this handler responds to (for MessageEvent).
     */
    public static function getMessageSourceClass(): string;
}
