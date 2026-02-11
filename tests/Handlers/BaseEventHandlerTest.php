<?php

namespace Phine\Tests\Handlers;

use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\MessageEvent;
use LINE\Webhook\Model\TextMessageContent;
use Phine\Client;
use Phine\Exceptions\NoDefinedException;
use Phine\Handlers\BaseEventHandler;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ConcreteEventHandler extends BaseEventHandler
{
    public const EVENT_CLASS = MessageEvent::class;
    public const MESSAGE_TYPE_CLASS = TextMessageContent::class;

    public function handle(Client $client, Event $event): void
    {
        // Do nothing
    }
}

class NoEventClassHandler extends BaseEventHandler
{
    public function handle(Client $client, Event $event): void
    {
        // Do nothing
    }
}

class NoMessageTypeHandler extends BaseEventHandler
{
    public const EVENT_CLASS = MessageEvent::class;

    public function handle(Client $client, Event $event): void
    {
        // Do nothing
    }
}

/**
 * @internal
 *
 * @coversNothing
 */
class BaseEventHandlerTest extends TestCase
{
    #[Test]
    public function getInstanceReturnsSameInstance(): void
    {
        $instance1 = ConcreteEventHandler::getInstance();
        $instance2 = ConcreteEventHandler::getInstance();

        $this->assertSame($instance1, $instance2);
    }

    #[Test]
    public function getEventClassReturnsCorrectClass(): void
    {
        $this->assertSame(MessageEvent::class, ConcreteEventHandler::getEventClass());
    }

    #[Test]
    public function getEventClassThrowsExceptionWhenNotDefined(): void
    {
        $this->expectException(NoDefinedException::class);
        $this->expectExceptionMessage('EVENT_CLASS constant not defined in handler.');

        NoEventClassHandler::getEventClass();
    }

    #[Test]
    public function getMessageContentClassReturnsCorrectClass(): void
    {
        $this->assertSame(TextMessageContent::class, ConcreteEventHandler::getMessageContentClass());
    }

    #[Test]
    public function getMessageContentClassThrowsExceptionWhenNotDefined(): void
    {
        $this->expectException(NoDefinedException::class);
        $this->expectExceptionMessage('MESSAGE_TYPE_CLASS constant not defined in message event handler.');

        NoMessageTypeHandler::getMessageContentClass();
    }

    #[Test]
    public function getMessageSourceClassReturnsAllByDefault(): void
    {
        $this->assertSame('all', ConcreteEventHandler::getMessageSourceClass());
    }
}
