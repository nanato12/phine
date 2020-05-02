<?php

/*

Client object

Copyright: nanato12

*/

namespace Phine;

use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;

class Client extends Service{
    function __construct($channelSecret, $channelAccessToken) {
        $this->time = microtime(true);
        $httpClient = new CurlHTTPClient($channelAccessToken);
        $this->client = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);
        $this->initialize();
    }

    function initialize(){
        parent::__construct($this);
    }
}

?>
