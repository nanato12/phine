<?php

namespace Phine\Helpers\MessageBuilders;

use LINE\Clients\MessagingApi\Model\Emoji;
use LINE\Clients\MessagingApi\Model\TextMessage;
use LINE\Constants\MessageType;

class TextMessageBuilder extends TextMessage
{
    /**
     * @param string      $text       Text
     * @param Emoji[]     $emojis     Emoji list
     * @param null|string $quoteToken Quote token
     */
    public function __construct(string $text, array $emojis = [], ?string $quoteToken = null)
    {
        parent::__construct();

        parent::setText($text);
        parent::setType(MessageType::TEXT);

        if (count($emojis)) {
            parent::setEmojis($emojis);
        }

        if (!is_null($quoteToken)) {
            parent::setQuoteToken($quoteToken);
        }
    }
}
