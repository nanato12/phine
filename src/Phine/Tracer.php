<?php

/*

Bot tracer object

Track events and execute added events

Copyright: nanato12

*/

namespace Phine;

use Exception;
use Phine\Types;

class Tracer extends Types {

    public $reactionEvents = [];

    function __construct($client, $debug=false) {
        $this->client = $client;
        $this->debug = $debug;
    }

    function addEvent($eventName, $func) {
        $this->reactionEvents[$eventName] = $func;
    }

    function trace($data, $signature) {
        try {
            $events = $this->client->parseEventRequest($data, $signature);
            foreach ($events as $event) {
                if ($this->debug) {
                    error_log("\n\n".json_encode((array)$event)."\n");
                }
                $this->client->addReplyToken($event->getReplyToken());
                $this->execute($event);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }

    function execute($event) {
        $eventType = $this->eventTypes[get_class($event)];
        if (array_key_exists($eventType, $this->reactionEvents)) {
            $this->reactionEvents[$eventType]($this->client, $event);
        }
    }

}

?>
