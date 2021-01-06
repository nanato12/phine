<?php

/**
 * Copyright 2020 nanato12
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Phine\Api;

use LINE\LINEBot\Event\BaseEvent;
use Phine\Client;
use Phine\Consts\Type;

interface ITracer
{
    function addEvent(string $eventName, string $func): void;
    function trace(string $data, string $signature): void;
    function execute(BaseEvent $event): void;
}

/**
 * Phine tracer
 *
 * @property Client $client         Phineクライアント
 * @property array  $reactionEvents 反応イベントリスト
 * @property bool   $debug          デバッグモード
 */
class Tracer implements ITracer
{
    public $client = null;
    public $reactionEvents = [];
    public $debug = false;

    /**
     * コンストラクタ
     *
     * @param Client $client Phineクライアント
     * @param bool   $debug  デバッグモード
     */
    function __construct(Client $client, bool $debug = false)
    {
        $this->client = $client;
        $this->debug = $debug;
    }

    /**
     * イベントと呼び出される関数を設定する関数
     *
     * @param string $eventName イベント名
     * @param string $func      関数名
     */
    function addEvent(string $eventName, $func): void
    {
        $this->reactionEvents[$eventName] = $func;
    }

    /**
     * トレース関数
     *
     * @param string $data      リクエストボディ
     * @param string $signature シグネチャ
     */
    function trace(string $data, string $signature): void
    {
        $events = $this->client->parseEventRequest($data, $signature);
        foreach ($events as $event) {
            if ($this->debug) {
                error_log("\n\n" . json_encode((array)$event) . "\n");
            }
            $this->client->setReplyToken($event->getReplyToken());
            $this->execute($event);
        }
    }

    /**
     * ハンドラを実行する関数
     *
     * @param BaseEvent $event イベント
     */
    function execute(BaseEvent $event): void
    {
        $eventType = Type::EVENT[get_class($event)];
        if (array_key_exists($eventType, $this->reactionEvents)) {
            $this->reactionEvents[$eventType]($this->client, $event);
        }
    }
}
