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

namespace Phine\Consts;

/**
 * Event object
 *
 * @link https://developers.line.biz/ja/reference/messaging-api/#webhook-event-objects
 */
class Event
{
    /**
     * メッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#message-event
     */
    const MESSAGE = "MessageEvent";

    /**
     * テキストメッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#wh-text
     */
    const TEXT_MESSAGE = "TextMessage";

    /**
     * 画像メッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#wh-image
     */
    const IMAGE_MESSAGE = "ImageMessage";

    /**
     * 動画メッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#wh-video
     */
    const VIDEO_MESSAGE = "VideoMessage";

    /**
     * 音声メッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#wh-audio
     */
    const AUDIO_MESSAGE = "AudioMessage";

    /**
     * ファイルメッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#wh-file
     */
    const FILE_MESSAGE = "FileMessage";

    /**
     * 位置情報メッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#wh-location
     */
    const LOCATION_MESSAGE = "LocationMessage";

    /**
     * スタンプメッセージイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#wh-sticker
     */
    const STICKER_MESSAGE = "StickerMessage";

    /**
     * 送信取消イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#unsend-event
     */
    const UNSEND_MESSAGE = "UnsendEvent";

    /**
     * フォローイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#follow-event
     */
    const FOLLOW = "FollowEvent";

    /**
     * フォロー解除イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#unfollow-event
     */
    const UNFOLLOW = "UnfollowEvent";

    /**
     * 参加イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#join-event
     */
    const JOIN = "JoinEvent";

    /**
     * 退出イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#leave-event
     */
    const LEAVE = "LeaveEvent";

    /**
     * メンバー参加イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#member-joined-event
     */
    const MEMBER_JOIN = "MemberJoinEvent";

    /**
     * メンバー退出イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#member-left-event
     */
    const MEMBER_LEAVE = "MemberLeaveEvent";

    /**
     * ポストバックイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#postback-event
     */
    const POSTBACK = "PostbackEvent";

    /**
     * 動画視聴完了イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#video-viewing-complete
     */
    const VIDEO_PLAY_COMPLETE = "VideoPlayCompleteEvent";

    /**
     * ビーコンイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#beacon-event
     */
    const BEACON_DETECTION = "BeaconDetectionEvent";

    /**
     * アカウント連携イベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#account-link-event
     */
    const ACCOUNT_LINK = "AccountLinkEvent";

    /**
     * LINE Thingsイベント
     * @link https://developers.line.biz/ja/reference/messaging-api/#device-link-event デバイス連携
     * @link https://developers.line.biz/ja/reference/messaging-api/#device-unlink-event デバイス連携解除
     * @link https://developers.line.biz/ja/reference/messaging-api/#scenario-result-event シナリオ実行
     */
    const THINGS = "ThingsEvent";

    /** 不明イベント */
    const UNKNOWN = "UnknownEvent";
    /** 不明メッセージイベント */
    const UNKNOWN_MESSAGE = "UnknownMessage";
}
