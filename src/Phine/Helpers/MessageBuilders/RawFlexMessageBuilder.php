<?php

namespace Phine\Helpers\MessageBuilders;

use LINE\Clients\MessagingApi\Model\FlexMessage;
use LINE\Constants\MessageType;

/**
 * Builder that generates FlexMessage from array.
 */
class RawFlexMessageBuilder extends FlexMessage
{
    /**
     * @param array<string, mixed> $contents Flex array contents
     * @param string               $altText  Alt text
     */
    public function __construct(array $contents, string $altText = 'Flex Message')
    {
        parent::__construct(['contents' => $contents]);
        parent::setAltText($altText);
        parent::setType(MessageType::FLEX);
    }
}
