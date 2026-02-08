<?php

namespace Phine\MessageBuilders;

use LINE\Clients\MessagingApi\Model\FlexMessage;
use LINE\Clients\MessagingApi\Model\Message;
use LINE\Constants\MessageType;

/**
 * Builder that generates FlexMessage from array.
 */
class RawFlexMessageBuilder extends FlexMessage implements MessageBuilderInterface
{
    public function build(): Message
    {
        return $this;
    }

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
