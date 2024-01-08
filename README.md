# Phine

LINE Messaging API SDK for PHP Wrapper

## Instance

### Client

This class is extend [LINE\Clients\MessagingApi\Api\MessagingApiApi](https://github.com/line/line-bot-sdk-php/blob/master/src/clients/messaging-api/lib/Api/MessagingApiApi.php).

```php
$client = new Client($channelAccessSecret, $channelAccessToken);
```

## Message Builders

### RawFlexMessageBuilder

Builder that generates FlexMessage from array.

in `flex.json`

```json
{"type":"carousel","contents":[{"type":"bubble", ...}]}
```

```php
$fileContent = file_get_contents("flex.json");
$flexContentArray = json_decode($fileContent, true);
$flexMessage = new RawFlexMessageBuilder($flexContentArray);
```

### TextMessageBuilder

```php
$textMessage = new TextMessageBuilder(
    text: 'text',
    emojis: [],
    quoteToken: 'quoteToken'
);
```

## Phine original functions

## setEvent

Function to hold the received event information in an instance.

Used in the `reply` function, etc.

```php
$client->setEvent($event);
```

## reply

Function to send a reply message.

A list of `Message`, `Sender`, and `QuickReply` can be included in the argument at the same time.

```php
$client->reply($messages, $sender, $quickReply);
```

## getProfileFromUserID

Function to retrieve a profile from a user ID.

A function that combines three functions: group user retrieval, room user retrieval, and user retrieval.

```php
$client->getProfileFromUserID($userID);
```
