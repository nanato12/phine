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

use Exception;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\MessageBuilder\RawMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\Response;
use LINE\LINEBot\SenderBuilder\SenderMessageBuilder;
use Phine\Structs\Group;
use Phine\Structs\Profile;

interface IService
{

    function setReplyToken(string $replyToken): void;
    function getProfileV2(string $userId): ?Profile;
    function getProfileFromGroup(string $userId, string $groupId): ?Profile;
    function getProfileFromRoom(string $userId, string $roomId): ?Profile;
    function getGroup(string $groupId): ?Group;
    function saveContentByMessageId(string $messageId, string $fileName = null): void;
    function replyMessageV2(array $messages): Response;
    function createRawMessage(array $content): RawMessageBuilder;
    function createTextMessage(string $text): RawMessageBuilder;
    function createImageMessage(string $contentUrl, ?string $previewUrl = null): ImageMessageBuilder;
    function createVideoMessage(string $contentUrl, string $previewUrl): VideoMessageBuilder;
    function createAudioMessage(string $contentUrl, int $duration): AudioMessageBuilder;
    function createStickerMessage(string $packageId, string $stickerId): StickerMessageBuilder;
    function createLocationMessage(
        string $title,
        string $address,
        float $latitude,
        float $longitude
    ): LocationMessageBuilder;
    function createFlexMessage(array $flexContent, string $altText = "Flex Message"): RawMessageBuilder;
    public static function createMultiMessage(array $messages): MultiMessageBuilder;
    function setQuickReply(array $items): void;
    function setSender(?string $name = null, ?string $iconUrl = null): void;
}

/**
 * @property string|null                   $replyToken     リプライトークン
 * @property SenderMessageBuilder|null     $sender         Senderインスタンス
 * @property array|null                    $senderData     Senderデータ
 * @property QuickReplyMessageBuilder|null $quickReply     quickReplyインスタンス
 * @property array|null                    $quickReplyData quickReplyデータ
 */
class Service extends LINEBot implements IService
{
    private $replyToken = null;
    private $sender = null;
    private $senderData = null;
    private $quickReply = null;
    private $quickReplyData = null;

    /**
     * コンストラクタ
     *
     * @param string $channelSecret      チャンネルシークレット
     * @param string $channelAccessToken アクセストークン
     */
    function __construct(string $channelSecret, string $channelAccessToken)
    {
        parent::__construct(
            new CurlHTTPClient($channelAccessToken),
            ["channelSecret" => $channelSecret]
        );
    }

    /**
     * リプライトークンを設定する関数
     *
     * @param string $replyToken リプライトークン
     */
    function setReplyToken(string $replyToken): void
    {
        $this->replyToken = $replyToken;
    }

    /**
     * ユーザーIDからプロフィール情報を取得する関数
     * getProfileのラッパー関数
     *
     * @param string $userId ユーザーID
     *
     * @return Profile|null プロフィール情報
     */
    function getProfileV2(string $userId): ?Profile
    {
        $profileInfo = json_decode(parent::getProfile($userId)->getRawBody(), true);
        if (array_key_exists("message", $profileInfo)) {
            return null;
        } else {
            $profile = new Profile;
            foreach ($profileInfo as $key => $value) {
                $profile->$key = $value;
            }
            return $profile;
        }
    }

    /**
     * グループIDとユーザーIDからプロフィール情報を取得する関数
     * getGroupMemberProfileのラッパー関数
     *
     * @param string $userId  ユーザーID
     * @param string $groupId グループID
     *
     * @return Profile|null プロフィール情報
     *
     * LINE Messaging APIの仕様上、下記2点は必ず *null* になる
     * - language
     * - statusMessage
     */
    function getProfileFromGroup(string $userId, string $groupId): ?Profile
    {
        $profileInfo = json_decode(parent::getGroupMemberProfile($groupId, $userId)->getRawBody(), true);
        if (array_key_exists("message", $profileInfo)) {
            return null;
        } else {
            $profile = new Profile;
            foreach ($profileInfo as $key => $value) {
                $profile->$key = $value;
            }
            return $profile;
        }
    }

    /**
     * ルームIDとユーザーIDからプロフィール情報を取得する関数
     * getRoomMemberProfileのラッパー関数
     *
     * @param string $userId ユーザーID
     * @param string $roomId ルームID
     *
     * @return Profile|null プロフィール情報
     *
     * LINE Messaging APIの仕様上、下記2点は必ず *null* になる
     * - language
     * - statusMessage
     */
    function getProfileFromRoom(string $userId, string $roomId): ?Profile
    {
        $profileInfo = json_decode(parent::getRoomMemberProfile($roomId, $userId)->getRawBody(), true);
        if (array_key_exists("message", $profileInfo)) {
            return null;
        } else {
            $profile = new Profile;
            foreach ($profileInfo as $key => $value) {
                $profile->$key = $value;
            }
            return $profile;
        }
    }

    /**
     * グループ情報を取得する関数
     * getGroupSummaryとgetGroupMembersCountのラッパー関数
     *
     * @param string $groupId グループID
     *
     * @return Group|null グループ情報
     */
    function getGroup(string $groupId): ?Group
    {
        $groupInfo = json_decode(parent::getGroupSummary($groupId)->getRawBody(), true);
        $groupInfo2 = json_decode(parent::getGroupMembersCount($groupId)->getRawBody(), true);
        if (
            array_key_exists("message", $groupInfo) &&
            array_key_exists("message", $groupInfo2)
        ) {
            return null;
        } else {
            $profile = new Group;
            foreach (array_merge($groupInfo, $groupInfo2) as $key => $value) {
                $profile->$key = $value;
            }
            return $profile;
        }
    }

    /**
     * 画像、動画、音声メッセージのコンテンツデータを保存する関数
     *
     * @param string      $messageId メッセージID
     * @param string|null $fileName  ファイル名
     *
     * @return void
     */
    function saveContentByMessageId(string $messageId, ?string $fileName = null): void
    {
        $res = parent::getMessageContent($messageId);
        if (is_null($fileName)) {
            $headers = $res->getHeaders();
            $fileInfo = explode("/", $headers["Content-Type"]);
            $directory = $fileInfo[0];
            $extention = $fileInfo[1];
            if (!file_exists("content/${directory}")) {
                mkdir("content/${directory}", 0777, true);
            }
            $fileName = "content/${directory}/${messageId}.${extention}";
        }
        file_put_contents($fileName, $res->getRawBody());
    }

    /**
     * リプライメッセージを送信する関数
     * replyMessageのラッパー関数
     *
     * @param array $messages メッセージリスト
     *
     * @return Response
     */
    function replyMessageV2(array $messages): Response
    {
        if (count($messages) > 5) {
            throw new Exception("You can send up to 5 messages at once.");
        }
        return parent::replyMessage(
            $this->replyToken,
            $this->createMultiMessage($messages)
        );
    }

    /**
     * rawメッセージを作成する
     *
     * @param array $content 生の配列データ
     *
     * @return RawMessageBuilder
     */
    function createRawMessage(array $content): RawMessageBuilder
    {
        if (!is_null($this->quickReplyData)) {
            $content['quickReply'] = $this->quickReplyData;
        }
        if (!is_null($this->senderData)) {
            $content['sender'] = $this->senderData;
        }
        return new RawMessageBuilder($content);
    }

    /**
     * テキストメッセージを作成する関数
     *
     * @param string $text テキスト
     *
     * @return RawMessageBuilder
     */
    function createTextMessage(string $text): RawMessageBuilder
    {
        $rawContent = [
            "type" => "text",
            "text" => $text
        ];
        return $this->createRawMessage($rawContent);
    }

    /**
     * 画像メッセージを作成する関数
     *
     * @param string      $contentUrl 画像コンテンツURL
     * @param string|null $previewUrl 画像サムネイルURL（指定しない場合、コンテンツURLが適用）
     *
     * @return ImageMessageBuilder
     */
    function createImageMessage(string $contentUrl, ?string $previewUrl = null): ImageMessageBuilder
    {
        if (is_null($previewUrl)) {
            $previewUrl = $contentUrl;
        }
        return new ImageMessageBuilder(
            $contentUrl,
            $previewUrl,
            $this->quickReply,
            $this->sender
        );
    }

    /**
     * 動画メッセージを作成する関数
     *
     * @param string $contentUrl 動画コンテンツURL
     * @param string $previewUrl 動画サムネイルURL
     *
     * @return VideoMessageBuilder
     */
    function createVideoMessage(string $contentUrl, string $previewUrl): VideoMessageBuilder
    {
        return new VideoMessageBuilder(
            $contentUrl,
            $previewUrl,
            $this->quickReply,
            $this->sender
        );
    }

    /**
     * 音声メッセージを作成する関数
     *
     * @param string $contentUrl 音声コンテンツURL
     * @param int    $duration   音声再生時間
     *
     * @return AudioMessageBuilder
     */
    function createAudioMessage(string $contentUrl, int $duration): AudioMessageBuilder
    {
        return new AudioMessageBuilder(
            $contentUrl,
            $duration,
            $this->quickReply,
            $this->sender
        );
    }

    /**
     * スタンプメッセージを作成する関数
     *
     * @param string $packageId パッケージID
     * @param string $stickerId ステッカーID
     *
     * @return StickerMessageBuilder
     */
    function createStickerMessage(string $packageId, string $stickerId): StickerMessageBuilder
    {
        return new StickerMessageBuilder(
            $packageId,
            $stickerId,
            $this->quickReply,
            $this->sender
        );
    }

    /**
     * 位置情報メッセージを作成する関数
     *
     * @param string $title     タイトル
     * @param string $address   住所
     * @param float  $latitude  緯度
     * @param float  $longitude 経度
     *
     * @return LocationMessageBuilder
     */
    function createLocationMessage(
        string $title,
        string $address,
        float $latitude,
        float $longitude
    ): LocationMessageBuilder {
        return new LocationMessageBuilder(
            $title,
            $address,
            $latitude,
            $longitude,
            $this->quickReply,
            $this->sender
        );
    }

    /**
     * FLEXメッセージを作成する関数
     *
     * @param array  $flexContent flexのデータ
     * @param string $altText     altメッセージ
     *
     * @return RawMessageBuilder
     */
    function createFlexMessage(array $flexContent, string $altText = "Flex Message"): RawMessageBuilder
    {
        $rawContent = [
            "type" => "flex",
            "altText" => $altText,
            "contents" => $flexContent,
        ];
        return $this->createRawMessage($rawContent);
    }

    /**
     * 複数メッセージを作成する関数
     *
     * @param array $messages メッセージの配列
     *
     * @return MultiMessageBuilder
     */
    public static function createMultiMessage(array $messages): MultiMessageBuilder
    {
        $multiMessage = new MultiMessageBuilder();
        foreach ($messages as $message) {
            $multiMessage->add($message);
        }
        return $multiMessage;
    }

    /**
     * クイックリプライを設定する関数
     *
     * @param array $items クリックリプライの配列
     *
     * @return void
     */
    function setQuickReply(array $items): void
    {
        $buttonBuilders = [];
        foreach ($items as $item) {
            $item_action = $item["action"];
            switch ($item_action["type"]) {
                case "message":
                    $action = new MessageTemplateActionBuilder($item_action["label"], $item_action["text"]);
                    break;
                case "camera":
                    $action = new CameraTemplateActionBuilder($item_action["label"]);
                    break;
                case "cameraRoll":
                    $action = new CameraRollTemplateActionBuilder($item_action["label"]);
                    break;
                case "location":
                    $action = new LocationTemplateActionBuilder($item_action["label"]);
                    break;
                case "postback":
                    $action = new PostbackTemplateActionBuilder($item_action["label"], $item_action["data"]);
                    break;
                case "datetimepicker":
                    $action = new DatetimePickerTemplateActionBuilder(
                        $item_action["label"],
                        $item_action["data"],
                        $item_action["mode"],
                        $item_action["initial"],
                        $item_action["max"],
                        $item_action["min"]
                    );
                    break;
                default:
                    throw new Exception("None action type: '{$item_action['type']}'");
            }
            array_push($buttonBuilders, new QuickReplyButtonBuilder($action));
        }
        $this->quickReply = new QuickReplyMessageBuilder($buttonBuilders);
        $this->quickReplyData = ["items" => $items];
    }

    /**
     * Senderを設定する関数
     *
     * @param string|null $name    表示名
     * @param string|null $iconUrl アイコンURL
     *
     * @return void
     */
    function setSender(?string $name = null, ?string $iconUrl = null): void
    {
        $this->sender = new SenderMessageBuilder($name, $iconUrl);
        $this->senderData = [
            "name" => $name,
            "iconUrl" => $iconUrl
        ];
    }
}
