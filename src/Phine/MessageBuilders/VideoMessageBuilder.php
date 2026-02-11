<?php

namespace Phine\MessageBuilders;

use LINE\Clients\MessagingApi\Model\Message;
use LINE\Clients\MessagingApi\Model\VideoMessage;
use LINE\Constants\MessageType;

/**
 * Builder that generates VideoMessage.
 */
class VideoMessageBuilder extends VideoMessage implements MessageBuilderInterface
{
    /**
     * @param string $originalContentUrl original video url
     * @param string $previewImageUrl    preview image url
     * @param string $trackingId         tracking id for video viewing
     */
    public function __construct(
        string $originalContentUrl,
        string $previewImageUrl,
        ?string $trackingId = null
    ) {
        parent::__construct();
        parent::setOriginalContentUrl($originalContentUrl);
        parent::setPreviewImageUrl($previewImageUrl);
        parent::setType(MessageType::VIDEO);

        if (!is_null($trackingId)) {
            parent::setTrackingId($trackingId);
        }
    }

    public function build(): Message
    {
        return $this;
    }
}
