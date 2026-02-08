<?php

namespace Phine\MessageBuilders;

use LINE\Clients\MessagingApi\Model\ImageMessage;
use LINE\Clients\MessagingApi\Model\Message;
use LINE\Constants\MessageType;

/**
 * Builder that generates ImageMessage.
 */
class ImageMessageBuilder extends ImageMessage implements MessageBuilderInterface
{
    public function build(): Message
    {
        return $this;
    }

    /**
     * @param string $originalContentUrl original image url
     * @param string $previewImageUrl    preview image url
     */
    public function __construct(string $originalContentUrl, string $previewImageUrl)
    {
        parent::__construct();
        parent::setOriginalContentUrl($originalContentUrl);
        parent::setPreviewImageUrl($previewImageUrl);
        parent::setType(MessageType::IMAGE);
    }
}
