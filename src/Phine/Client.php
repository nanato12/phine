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

namespace Phine;

use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\SenderBuilder\SenderMessageBuilder;
use Phine\Api\Service;

/**
 * Phine client (LINE Messaging API).
 *
 * @property    float   $time インスタンスが作成された時間
 * @property    SenderMessageBuilder    $sender Senderインスタンス
 * @property    QuickReplyMessageBuilder    $quickReply quickReplyインスタンス
 */
class Client extends Service
{
    public $time = 0;
    public $sender = null;
    public $quickReply = null;

    /**
     * @param   string  $channelSecret チャンネルシークレト
     * @param   string  $channelAccessToken アクセストークン
     */
    function __construct(string $channelSecret, string $channelAccessToken)
    {
        $this->time = microtime(true);
        parent::__construct($channelSecret, $channelAccessToken);
    }
}
