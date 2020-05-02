<?php

/*

Track events and execute added events

Copyright: nanato12

*/

namespace Phine;

class Tracer extends Types {

    public $reactionEvents = array();

    function __construct($client, $debug=false) {
        $this->client = $client;
        $this->debug = $debug;
    }

    function addEvent($eventName, $func){
        $this->reactionEvents[$eventName] = $func;
    }

    function trace($data, $signature){
        try {
            $events = $this->client->client->parseEventRequest($data, $signature);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        foreach ($events as $event) {
            $this->execute($event);
            if ($this->debug){
                error_log(get_class($event));
            }
        }
    }

    function execute($event){
        $eventType = $this->eventTypes[get_class($event)];
        if (array_key_exists($eventType, $this->reactionEvents)){
            try {
                $this->reactionEvents[$eventType]($this->client, $event);
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
    }
}

?>
