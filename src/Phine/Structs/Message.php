<?php

/*

Bot message object

Create referring to here.
https://line.github.io/line-bot-sdk-php/class-LINE.LINEBot.html

Copyright: nanato12

*/

namespace Phine\Structs;

use Exception;

use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\RawMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;

use LINE\LINEBot\SenderBuilder\SenderMessageBuilder;

use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;

use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;

class Message
{
    public $quickReply = null;
    public $sender = null;

    public $quickReplyData = null;
    public $senderData = null;

    function createTextMessage(string $text): RawMessageBuilder
    {
        $rawContent = [
            'type' => 'text',
            'text' => $text
        ];
        return $this->createRawMessage($rawContent);
    }

    function createImageMessage(string $imageUrl): ImageMessageBuilder
    {
        return new ImageMessageBuilder($imageUrl, $imageUrl, $this->quickReply, $this->sender);
    }

    function createVideoMessage(array $videoContent): VideoMessageBuilder
    {
        return new VideoMessageBuilder(
            $videoContent['contentUrl'],
            $videoContent['previewUrl'],
            $this->quickReply,
            $this->sender
        );
    }

    function createAudioMessage(array $audioContent): AudioMessageBuilder
    {
        return new AudioMessageBuilder(
            $audioContent['contentUrl'],
            $audioContent['duration'],
            $this->quickReply,
            $this->sender
        );
    }

    function createStickerMessage(array $stickerContent): StickerMessageBuilder
    {
        return new StickerMessageBuilder(
            $stickerContent['packageId'],
            $stickerContent['stickerId'],
            $this->quickReply,
            $this->sender
        );
    }

    function createLocationMessage(array $locationContent): LocationMessageBuilder
    {
        return new LocationMessageBuilder(
            $locationContent['title'],
            $locationContent['address'],
            $locationContent['latitude'],
            $locationContent['longitude'],
            $this->quickReply,
            $this->sender
        );
    }

    function createFlexMessage(array $flexContent, string $altText = 'Flex Message'): RawMessageBuilder
    {
        $rawContent = [
            'type' => 'flex',
            'altText' => $altText,
            'contents' => $flexContent
        ];
        return $this->createRawMessage($rawContent);
    }

    function createRawMessage(array $content): RawMessageBuilder
    {
        if (!is_null($this->quickReplyData)) {
            $content['quickReply'] = $this->quickReplyData;
        }
        if (!is_null($this->senderData)) {
            $content['sender'] = $this->senderData;
        }
        return new RawMessageBuilder($content);
    }

    function createMultiMessage(array $messages): MultiMessageBuilder
    {
        if (count($messages) > 5) {
            throw new Exception('send messages limit 5 at onece.');
        }
        $multiMessage = new MultiMessageBuilder();
        foreach ($messages as $message) {
            $multiMessage->add($message);
        }
        return $multiMessage;
    }

    function setQuickReply(array $items): void
    {
        $buttons = [];
        foreach ($items as $item) {
            $item_action = $item['action'];
            switch ($item_action['type']) {
                case 'message':
                    $action = new MessageTemplateActionBuilder($item_action['label'], $item_action['text']);
                    break;
                case 'camera':
                    $action = new CameraTemplateActionBuilder($item_action['label']);
                    break;
                case 'cameraRoll':
                    $action = new CameraRollTemplateActionBuilder($item_action['label']);
                    break;
                case 'location':
                    $action = new LocationTemplateActionBuilder($item_action['label']);
                    break;
                case 'postback':
                    $action = new PostbackTemplateActionBuilder($item_action['label'], $item_action['data']);
                    break;
                case 'datetimepicker':
                    $action = new DatetimePickerTemplateActionBuilder(
                        $item_action['label'],
                        $item_action['data'],
                        $item_action['mode'],
                        $item_action['initial'],
                        $item_action['max'],
                        $item_action['min']
                    );
                    break;
                default:
                    throw new Exception("None action type: '{$item_action['type']}'");
            }
            $button = new QuickReplyButtonBuilder($action);
            array_push($buttons, $button);
        }
        $this->quickReply = new QuickReplyMessageBuilder($buttons);
        $this->quickReplyData = ['items' => $items];
    }

    function setSender(string $name, string $iconUrl): void
    {
        $this->sender = new SenderMessageBuilder($name, $iconUrl);
        $this->senderData = [
            'name' => $name,
            'iconUrl' => $iconUrl
        ];
    }
}