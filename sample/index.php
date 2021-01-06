<?php

include(__DIR__ . '/op/RecieveText.php');
require_once(__DIR__ . '/../vendor/autoload.php');

use LINE\LINEBot\Constant\HTTPHeader;
use Phine\Api\Tracer;
use Phine\Client;
use Phine\Consts\Event;

// account.jsonからアカウント情報を読み込む
$account = json_decode(file_get_contents('./account.json'));
$channelSecret = $account->channel_secret;
$channelAccessToken = $account->channel_access_token;

// インスタンス化
$bot = new Client($channelSecret, $channelAccessToken);
$tracer = new Tracer($bot, true);

// 各種イベントと実行する関数名を設定
$tracer->addEvent(Event::TEXT_MESSAGE, 'receiveTextMessage');

if (isset($_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE])) {
    $data = file_get_contents('php://input');
    $signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
    $tracer->trace($data, $signature);
}
