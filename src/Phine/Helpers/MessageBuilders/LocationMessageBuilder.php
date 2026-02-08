<?php

namespace Phine\Helpers\MessageBuilders;

use LINE\Clients\MessagingApi\Model\LocationMessage;
use LINE\Constants\MessageType;

/**
 * Builder that generates LocationMessage.
 */
class LocationMessageBuilder extends LocationMessage
{
    /**
     * @param string $title     location title
     * @param string $address   location address
     * @param float  $latitude  latitude
     * @param float  $longitude longitude
     */
    public function __construct(
        string $title,
        string $address,
        float $latitude,
        float $longitude
    ) {
        parent::__construct();
        parent::setTitle($title);
        parent::setAddress($address);
        parent::setLatitude($latitude);
        parent::setLongitude($longitude);
        parent::setType(MessageType::LOCATION);
    }
}
