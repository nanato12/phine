<?php

/*

Bot client object

Copyright: nanato12

*/

namespace Phine;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Client extends Service {

    function __construct($channelSecret, $channelAccessToken) {
        $this->time = microtime(true);
        $this->client = new LINEBot(
            new CurlHTTPClient($channelAccessToken),
            ['channelSecret' => $channelSecret]
        );
        $this->initialize();
    }

    function initialize() {
        parent::__construct($this);
    }

    function addReplyToken($replyToken) {
        $this->setReplyToken($replyToken);
    }
}

?>
