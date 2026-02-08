# Phine

LINE Messaging API SDK for PHP Wrapper

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

$client = new Client($channelAccessSecret, $channelAccessToken);

// Parse webhook events
$events = $client->parseEventRequest($body, $signature);

foreach ($events as $event) {
    $client->setEvent($event);
    $client->reply([new TextMessageBuilder('Hello!')]);
}
```

## Client

This class extends [LINE\Clients\MessagingApi\Api\MessagingApiApi](https://github.com/line/line-bot-sdk-php/blob/master/src/clients/messaging-api/lib/Api/MessagingApiApi.php).

```php
$client = new Client($channelAccessSecret, $channelAccessToken);
```

## Message Builders

### TextMessageBuilder

```php
use Phine\Helpers\MessageBuilders\TextMessageBuilder;

$textMessage = new TextMessageBuilder(
    text: 'Hello!',
    emojis: [],
    quoteToken: 'quoteToken'
);
```

### RawFlexMessageBuilder

Builder that generates FlexMessage from array.

```php
use Phine\Helpers\MessageBuilders\RawFlexMessageBuilder;

$fileContent = file_get_contents("flex.json");
$flexContentArray = json_decode($fileContent, true);
$flexMessage = new RawFlexMessageBuilder($flexContentArray, 'Alt Text');
```

### ImageMessageBuilder

```php
use Phine\Helpers\MessageBuilders\ImageMessageBuilder;

$imageMessage = new ImageMessageBuilder(
    originalContentUrl: 'https://example.com/original.jpg',
    previewImageUrl: 'https://example.com/preview.jpg'
);
```

### VideoMessageBuilder

```php
use Phine\Helpers\MessageBuilders\VideoMessageBuilder;

$videoMessage = new VideoMessageBuilder(
    originalContentUrl: 'https://example.com/video.mp4',
    previewImageUrl: 'https://example.com/preview.jpg',
    trackingId: 'tracking-123' // optional
);
```

### AudioMessageBuilder

```php
use Phine\Helpers\MessageBuilders\AudioMessageBuilder;

$audioMessage = new AudioMessageBuilder(
    originalContentUrl: 'https://example.com/audio.m4a',
    duration: 60000 // milliseconds
);
```

### StickerMessageBuilder

```php
use Phine\Helpers\MessageBuilders\StickerMessageBuilder;

$stickerMessage = new StickerMessageBuilder(
    packageId: '446',
    stickerId: '1988'
);
```

### LocationMessageBuilder

```php
use Phine\Helpers\MessageBuilders\LocationMessageBuilder;

$locationMessage = new LocationMessageBuilder(
    title: 'Tokyo Station',
    address: '1 Chome Marunouchi, Chiyoda City, Tokyo',
    latitude: 35.6812,
    longitude: 139.7671
);
```

## Client Methods

### setEvent

Function to hold the received event information in an instance.

```php
$client->setEvent($event);
```

### reply

Function to send a reply message.

```php
$client->reply($messages, $sender, $quickReply);
```

### push

Function to send a push message.

```php
$client->push($to, $messages, $sender, $quickReply);
```

### sendMulticast

Function to send a multicast message to multiple users (max 500).

```php
$client->sendMulticast($userIds, $messages, $sender, $quickReply);
```

### sendBroadcast

Function to send a broadcast message to all users.

```php
$client->sendBroadcast($messages, $sender, $quickReply);
```

### getProfileFromUserID

Function to retrieve a profile from a user ID. Automatically handles group/room context.

```php
$profile = $client->getProfileFromUserID($userID);
echo $profile->displayName;
```

## Event Handlers

### BaseEventHandler

Create event handlers by extending `BaseEventHandler`:

```php
use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\MessageEvent;
use LINE\Webhook\Model\TextMessageContent;
use Phine\Client;
use Phine\Handlers\BaseEventHandler;

class TextMessageHandler extends BaseEventHandler
{
    public const EVENT_CLASS = MessageEvent::class;
    public const MESSAGE_TYPE_CLASS = TextMessageContent::class;

    public function handle(Client $client, Event $event): void
    {
        $client->reply([new TextMessageBuilder('Received!')]);
    }
}
```

### BaseCommandHandler

Create command handlers for specific text commands:

```php
use LINE\Webhook\Model\Event;
use Phine\Client;
use Phine\Handlers\BaseCommandHandler;
use Phine\Helpers\MessageBuilders\TextMessageBuilder;

class HelloHandler extends BaseCommandHandler
{
    public static function commands(): array
    {
        return ['hello', 'hi'];
    }

    public function handle(Client $client, Event $event): void
    {
        $client->reply([new TextMessageBuilder('Hello!')]);
    }
}
```

For prefix matching (commands with arguments):

```php
class SearchHandler extends BaseCommandHandler
{
    public static function commands(): array
    {
        return ['search '];
    }

    public static function isPrefix(): bool
    {
        return true;
    }

    public function handle(Client $client, Event $event): void
    {
        // Handle "search keyword" commands
    }
}
```

### EventDispatcher

Dispatch events to registered handlers:

```php
use Phine\Handlers\EventDispatcher;

class MyDispatcher extends EventDispatcher
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

// Usage
foreach ($events as $event) {
    MyDispatcher::dispatch($client, $event);
}
```

## License

Apache-2.0
