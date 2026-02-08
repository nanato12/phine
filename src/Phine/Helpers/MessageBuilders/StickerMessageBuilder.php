<?php

namespace Phine\Helpers\MessageBuilders;

use LINE\Clients\MessagingApi\Model\Message;
use LINE\Clients\MessagingApi\Model\StickerMessage;
use LINE\Constants\MessageType;

/**
 * Builder that generates StickerMessage.
 */
class StickerMessageBuilder extends StickerMessage implements MessageBuilderInterface
{
    public function build(): Message
    {
        return $this;
    }

    /**
     * @param string $packageId package id
     * @param string $stickerId sticker id
     * @param string $quoteToken quote token
     */
    public function __construct(
        string $packageId,
        string $stickerId,
        ?string $quoteToken = null
    ) {
        parent::__construct();
        parent::setPackageId($packageId);
        parent::setStickerId($stickerId);
        parent::setType(MessageType::STICKER);

        if (!is_null($quoteToken)) {
            parent::setQuoteToken($quoteToken);
        }
    }
}
