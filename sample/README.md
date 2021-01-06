# Sample Bot

`account.json`を作成する。
```json
{
    "channel_secret": "XXXXXXXX",
    "channel_access_token": "XXXXXXXXXXXXXXXXXX"
}
```

`Client`と`Tracer`をインスタンス化する。
```php
$bot = new Client($channelSecret, $channelAccessToken);
$tracer = new Tracer($bot, true);
```

[Phine\Consts\Event](../src/Phine/Consts/Event.php) からイベントを指定、そのイベントに反応する関数名を`addEvent`する。  
サンプルにある `receiveTextMessage` は [ここ](./op/RecieveText.php)
```php
$tracer->addEvent(Event::TEXT_MESSAGE, 'receiveTextMessage');
```

あとはLINEからのリクエストであるか判定して`tracer`に必要な情報を投げる。
```php
if (isset($_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE])) {
    $data = file_get_contents('php://input');
    $signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
    $tracer->trace($data, $signature);
}
```
