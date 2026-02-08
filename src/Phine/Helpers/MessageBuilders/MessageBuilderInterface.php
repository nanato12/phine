<?php

namespace Phine\Helpers\MessageBuilders;

use LINE\Clients\MessagingApi\Model\Message;

/**
 * Interface for message builders.
 */
interface MessageBuilderInterface
{
    /**
     * Build and return the message.
     */
    public function build(): Message;
}
