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
 * Type object
 *
 * @link https://line.github.io/line-bot-sdk-php/class-LINE.LINEBot.Event.BaseEvent.html LINE Official Bot Event
 */
class Type
{
    /** @var array クラスに対するイベント名のリスト */
    const EVENT = [
        'LINE\LINEBot\Event\AccountLinkEvent' => Event::ACCOUNT_LINK,
        'LINE\LINEBot\Event\BeaconDetectionEvent' => Event::BEACON_DETECTION,
        'LINE\LINEBot\Event\ThingsEvent' => Event::THINGS,
        'LINE\LINEBot\Event\FollowEvent' => Event::FOLLOW,
        'LINE\LINEBot\Event\UnfollowEvent' => Event::UNFOLLOW,
        'LINE\LINEBot\Event\PostbackEvent' => Event::POSTBACK,
        'LINE\LINEBot\Event\JoinEvent' => Event::JOIN,
        'LINE\LINEBot\Event\LeaveEvent' => Event::LEAVE,
        'LINE\LINEBot\Event\MemberJoinEvent' => Event::MEMBER_JOIN,
        'LINE\LINEBot\Event\MemberLeaveEvent' => Event::MEMBER_LEAVE,
        'LINE\LINEBot\Event\MessageEvent' => Event::MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\TextMessage' => Event::TEXT_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\ImageMessage' => Event::IMAGE_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\VideoMessage' => Event::VIDEO_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\AudioMessage' => Event::AUDIO_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\FileMessage' => Event::FILE_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\StickerMessage' => Event::STICKER_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\LocationMessage' => Event::LOCATION_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\UnknownMessage' => Event::UNKNOWN_MESSAGE,
        'LINE\LINEBot\Event\UnsendEvent' => Event::UNSEND_MESSAGE,
        'LINE\LINEBot\Event\VideoPlayCompleteEvent' => Event::VIDEO_PLAY_COMPLETE,
        'LINE\LINEBot\Event\UnknownEvent' => Event::UNKNOWN,
    ];
}
