# phine
LINE Official Bot PHP Library

## Instance
### Client
This class is extend `LINEBot`.
```php
$client = new Client($channelSecret, $channelAccessToken);
```

### Tracer
```php
$tracer = new Tracer($client, true);
```

## Event action
- Function definition
```php
function receiveTextMessage(Client $client, MessageEvent $event)
{
    ...
}
```

- Add Event
```php
$tracer->addEvent(Event::TEXT_MESSAGE, 'receiveTextMessage');
```

## Phine original object
### Profile object ([here](./src/Phine/Structs/Profile.php))
```php
class Profile
{
    public $userId = null;
    public $displayName = null;
    public $pictureUrl = null;
    public $language = null;
    public $statusMessage = null;
}
```
### Group object ([here](./src/Phine/Structs/Group.php))
```php
class Group
{
    public $groupId = null;
    public $groupName = null;
    public $pictureUrl = null;
    public $count = null;
}
```

## Phine original function
### getProfileV2
Gets user profile by `userId`, returns `Profile` object.
```php
function getProfileV2(string $userId): ?Profile
```

### getProfileFromGroup
Gets user profile by `userId` and `groupId`, returns `Profile` object.
```php
function getProfileFromGroup(string $userId, string $groupId): ?Profile
```

### getProfileFromRoom
Gets user profile by `userId` and `roomId`, returns `Profile` object.

```php
function getProfileFromRoom(string $userId, string $roomId): ?Profile
```

### getGroup
Gets group information by `groupId`, returns `Group` object.
```php
function getGroup(string $groupId): ?Group
```

### saveContentByMessageId
Save message content by `messageId`.
```php
function saveContentByMessageId(string $messageId, ?string $fileName = null): void
```
### createRawMessage
```php
function createRawMessage(array $content): RawMessageBuilder
```

### createTextMessage
```php
function createTextMessage(string $text): RawMessageBuilder
```

### createImageMessage
```php
function createImageMessage(string $contentUrl, ?string $previewUrl = null): ImageMessageBuilder
```

### createVideoMessage
```php
function createVideoMessage(string $contentUrl, string $previewUrl): VideoMessageBuilder
```

### createAudioMessage
```php
function createAudioMessage(string $contentUrl, int $duration): AudioMessageBuilder
```

### createStickerMessage
```php
function createStickerMessage(string $packageId, string $stickerId): StickerMessageBuilder
```

### createLocationMessage
```php
function createLocationMessage(
    string $title,
    string $address,
    float $latitude,
    float $longitude
): LocationMessageBuilder
```

### createFlexMessage
```php
function createFlexMessage(array $flexContent, string $altText = "Flex Message"): RawMessageBuilder
```

### createMultiMessage
```php
public static function createMultiMessage(array $messages): MultiMessageBuilder
```

### replyMessageV2
Wrapping `LINEBot::replyMessage`.  
No `replyToken` is required.
```php
function replyMessageV2(array $messages): Response
```
Example
```php
$messages = [
    $client->createTextMessage("test1"),
    $client->createTextMessage("test2")
];
$client->replyMessageV2($messages);
```

### setQuickReply
Set up a `QuickReply`.  
Must be done before composing a message.
```php
function setQuickReply(array $items): void
```

### setSender
Set up a `Sender`.  
Must be done before composing a message.
```php
function setSender(?string $name = null, ?string $iconUrl = null): void
```

## [Sample Bot](./sample/)
- Text Message Event
