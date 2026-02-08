<?php

namespace Phine\Helpers\MessageBuilders;

use LINE\Clients\MessagingApi\Model\AudioMessage;
use LINE\Constants\MessageType;

/**
 * Builder that generates AudioMessage.
 */
class AudioMessageBuilder extends AudioMessage
{
    /**
     * @param string $originalContentUrl original audio url
     * @param int    $duration           audio duration in milliseconds
     */
    public function __construct(string $originalContentUrl, int $duration)
    {
        parent::__construct();
        parent::setOriginalContentUrl($originalContentUrl);
        parent::setDuration($duration);
        parent::setType(MessageType::AUDIO);
    }
}
