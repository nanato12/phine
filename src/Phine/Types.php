<?php

/*

Bot event type object

LINE Official Bot Event
https://line.github.io/line-bot-sdk-php/class-LINE.LINEBot.Event.BaseEvent.html

Copyright: nanato12

*/

namespace Phine;

class Types
{
    public $eventTypes = [
        'LINE\LINEBot\Event\AccountLinkEvent' => Config::EVENT_ACCOUNT_LINK,
        'LINE\LINEBot\Event\BeaconDetectionEvent' => Config::EVENT_BEACON_DETECTION,
        'LINE\LINEBot\Event\ThingsEvent' => Config::EVENT_THINGS,
        'LINE\LINEBot\Event\FollowEvent' => Config::EVENT_FOLLOW,
        'LINE\LINEBot\Event\UnfollowEvent' => Config::EVENT_UNFOLLOW,
        'LINE\LINEBot\Event\PostbackEvent' => Config::EVENT_POSTBACK,
        'LINE\LINEBot\Event\JoinEvent' => Config::EVENT_JOIN,
        'LINE\LINEBot\Event\LeaveEvent' => Config::EVENT_LEAVE,
        'LINE\LINEBot\Event\MemberJoinEvent' => Config::EVENT_MEMBER_JOIN,
        'LINE\LINEBot\Event\MemberLeaveEvent' => Config::EVENT_MEMBER_LEAVE,
        'LINE\LINEBot\Event\MessageEvent' => Config::EVENT_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\TextMessage' => Config::EVENT_TEXT_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\ImageMessage' => Config::EVENT_IMAGE_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\VideoMessage' => Config::EVENT_VIDEO_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\AudioMessage' => Config::EVENT_AUDIO_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\FileMessage' => Config::EVENT_FILE_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\StickerMessage' => Config::EVENT_STICKER_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\LocationMessage' => Config::EVENT_LOCATION_MESSAGE,
        'LINE\LINEBot\Event\MessageEvent\UnknownMessage' => Config::EVENT_UNKNOWN_MESSAGE,
        'LINE\LINEBot\Event\UnsendEvent' => Config::EVENT_UNSEND_MESSAGE,
        'LINE\LINEBot\Event\VideoPlayCompleteEvent' => Config::EVENT_VIDEO_PLAY_COMPLETE,
        'LINE\LINEBot\Event\UnknownEvent' => Config::EVENT_UNKNOWN,
    ];
}
