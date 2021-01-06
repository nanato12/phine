<?php

/*

Bot event type object

LINE Official Bot Event
https://line.github.io/line-bot-sdk-php/class-LINE.LINEBot.Event.BaseEvent.html

Copyright: nanato12

*/

namespace Phine\Consts;

class Type
{
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
