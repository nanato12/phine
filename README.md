# Phine

A developer-friendly wrapper for the LINE Messaging API SDK for PHP.

Phine simplifies common LINE bot operations by providing intuitive message builders, event handlers, and convenient client methods.

## Installation

```bash
composer require nanato12/phine
```

## Requirements

- PHP >= 8.1
- linecorp/line-bot-sdk ^12.4

## Quick Start

```php
use Phine\Client;
use Phine\Helpers\MessageBuilders\TextMessageBuilder;

$client = new Client($channelSecret, $channelAccessToken);

// Parse incoming webhook request
$events = $client->parseEventRequest($requestBody, $signature);

foreach ($events as $event) {
    $client->setEvent($event);
    $client->reply([new TextMessageBuilder('Hello!')]);
}
```

## Client

The `Client` class extends `MessagingApiApi` from the official LINE SDK, so all original methods are available.

```php
$client = new Client($channelSecret, $channelAccessToken);
```

## Message Builders

Phine provides convenient builders for creating LINE messages.

### TextMessageBuilder

```php
use Phine\Helpers\MessageBuilders\TextMessageBuilder;

// Simple text message
$message = new TextMessageBuilder('Hello!');

// With LINE emojis and quote
$message = new TextMessageBuilder(
    text: '$ Hello!',
    emojis: [$emoji],
    quoteToken: 'quote-token'
);
```

### RawFlexMessageBuilder

Build Flex Messages from a JSON array. Useful when designing messages with the [Flex Message Simulator](https://developers.line.biz/flex-simulator/).

```php
use Phine\Helpers\MessageBuilders\RawFlexMessageBuilder;

$json = file_get_contents('flex.json');
$contents = json_decode($json, true);
$message = new RawFlexMessageBuilder($contents, 'Alt text for notifications');
```

### ImageMessageBuilder

```php
use Phine\Helpers\MessageBuilders\ImageMessageBuilder;

$message = new ImageMessageBuilder(
    originalContentUrl: 'https://example.com/image.jpg',
    previewImageUrl: 'https://example.com/image-preview.jpg'
);
```

### VideoMessageBuilder

```php
use Phine\Helpers\MessageBuilders\VideoMessageBuilder;

$message = new VideoMessageBuilder(
    originalContentUrl: 'https://example.com/video.mp4',
    previewImageUrl: 'https://example.com/video-thumbnail.jpg',
    trackingId: 'tracking-123' // optional, for tracking video views
);
```

### AudioMessageBuilder

```php
use Phine\Helpers\MessageBuilders\AudioMessageBuilder;

$message = new AudioMessageBuilder(
    originalContentUrl: 'https://example.com/audio.m4a',
    duration: 60000 // duration in milliseconds
);
```

### StickerMessageBuilder

```php
use Phine\Helpers\MessageBuilders\StickerMessageBuilder;

$message = new StickerMessageBuilder(
    packageId: '446',
    stickerId: '1988'
);
```

### LocationMessageBuilder

```php
use Phine\Helpers\MessageBuilders\LocationMessageBuilder;

$message = new LocationMessageBuilder(
    title: 'Tokyo Station',
    address: '1 Chome Marunouchi, Chiyoda City, Tokyo',
    latitude: 35.6812,
    longitude: 139.7671
);
```

## Client Methods

### parseEventRequest

Parses the incoming webhook request body and validates the signature.

```php
$events = $client->parseEventRequest($requestBody, $signature);
```

### setEvent

Stores the current event in the client instance. Required before calling `reply()`.

```php
$client->setEvent($event);
```

### reply

Sends a reply message to the user. Must call `setEvent()` first.

```php
// Simple reply
$client->reply([new TextMessageBuilder('Hello!')]);

// With sender icon and quick reply buttons
$client->reply($messages, $sender, $quickReply);
```

### push

Sends a push message to a specific user, group, or room.

```php
$client->push($userId, [new TextMessageBuilder('Hello!')]);

// With sender and quick reply
$client->push($userId, $messages, $sender, $quickReply);
```

### sendMulticast

Sends a message to multiple users at once (up to 500 users).

```php
$userIds = ['U1234...', 'U5678...'];
$client->sendMulticast($userIds, [new TextMessageBuilder('Hello everyone!')]);
```

### sendBroadcast

Sends a message to all users who have added your bot as a friend.

```php
$client->sendBroadcast([new TextMessageBuilder('Announcement!')]);
```

### getProfileFromUserID

Retrieves a user's profile. Automatically uses the appropriate API based on the event source (user, group, or room).

```php
$profile = $client->getProfileFromUserID($userId);

echo $profile->displayName;
echo $profile->pictureUrl;
echo $profile->statusMessage; // Only available for 1:1 chats
```

## Event Handlers

Phine provides an event handling system to organize your bot logic.

### BaseEventHandler

Create handlers for specific event types:

```php
use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\MessageEvent;
use LINE\Webhook\Model\TextMessageContent;
use Phine\Client;
use Phine\Handlers\BaseEventHandler;
use Phine\Helpers\MessageBuilders\TextMessageBuilder;

class TextMessageHandler extends BaseEventHandler
{
    public const EVENT_CLASS = MessageEvent::class;
    public const MESSAGE_TYPE_CLASS = TextMessageContent::class;
    // Optional: public const MESSAGE_SOURCE_CLASS = GroupSource::class;

    public function handle(Client $client, Event $event): void
    {
        $client->reply([new TextMessageBuilder('Message received!')]);
    }
}
```

### BaseCommandHandler

Create handlers that respond to specific text commands:

```php
use LINE\Webhook\Model\Event;
use Phine\Client;
use Phine\Handlers\BaseCommandHandler;
use Phine\Helpers\MessageBuilders\TextMessageBuilder;

class HelloHandler extends BaseCommandHandler
{
    public static function commands(): array
    {
        return ['hello', 'hi', 'hey'];
    }

    public function handle(Client $client, Event $event): void
    {
        $client->reply([new TextMessageBuilder('Hello!')]);
    }
}
```

For commands with arguments, use prefix matching:

```php
class SearchHandler extends BaseCommandHandler
{
    public static function commands(): array
    {
        return ['search '];
    }

    public static function isPrefix(): bool
    {
        return true; // Matches "search foo", "search bar", etc.
    }

    public function handle(Client $client, Event $event): void
    {
        /** @var MessageEvent $event */
        /** @var TextMessageContent $message */
        $message = $event->getMessage();
        $keyword = substr($message->getText(), 7); // Remove "search "

        // Search logic here...
    }
}
```

### EventDispatcher

Register and dispatch events to your handlers:

```php
use Phine\Handlers\EventDispatcher;

class BotDispatcher extends EventDispatcher
{
    public function getHandlerClasses(): array
    {
        return [
            TextMessageHandler::class,
            HelloHandler::class,
            SearchHandler::class,
        ];
    }
}

// In your webhook endpoint
$events = $client->parseEventRequest($body, $signature);

foreach ($events as $event) {
    BotDispatcher::dispatch($client, $event);
}
```

## License

Apache-2.0
