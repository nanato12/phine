<?php

/*

Client object

Copyright: nanato12

*/

namespace Phine;

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Client extends Service{
    function __construct($channelSecret, $channelAccessToken) {
        $this->time = microtime(true);
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
        $this->client = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
        $this->initialize();
    }

    function initialize(){
        parent::__construct($this);
    }
}

?>
