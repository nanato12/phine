<?php

/*

LINE Official Bot Event
https://line.github.io/line-bot-sdk-php/class-LINE.LINEBot.Event.BaseEvent.html

Copyright: nanato12

*/

namespace Phine;

class Types{
    public $eventTypes = array(
        'LINE\LINEBot\Event\AccountLinkEvent' => 'AccountLinkEvent',
        'LINE\LINEBot\Event\BeaconDetectionEvent' => 'BeaconDetectionEvent',
        'LINE\LINEBot\Event\FollowEvent' => 'FollowEvent',
        'LINE\LINEBot\Event\JoinEvent' => 'JoinEvent',
        'LINE\LINEBot\Event\LeaveEvent' => 'LeaveEvent',
        'LINE\LINEBot\Event\MemberJoinEvent' => 'MemberJoinEvent',
        'LINE\LINEBot\Event\MemberLeaveEvent' => 'MemberLeaveEvent',
        'LINE\LINEBot\Event\MessageEvent' => 'MessageEvent',
        'LINE\LINEBot\Event\MessageEvent\AudioMessage' => 'AudioMessage',
        'LINE\LINEBot\Event\MessageEvent\FileMessage' => 'FileMessage',
        'LINE\LINEBot\Event\MessageEvent\ImageMessage' => 'ImageMessage',
        'LINE\LINEBot\Event\MessageEvent\LocationMessage' => 'LocationMessage',
        'LINE\LINEBot\Event\MessageEvent\StickerMessage' => 'StickerMessage',
        'LINE\LINEBot\Event\MessageEvent\TextMessage' => 'TextMessage',
        'LINE\LINEBot\Event\MessageEvent\UnknownMessage' => 'UnknownMessage',
        'LINE\LINEBot\Event\MessageEvent\VideoMessage' => 'VideoMessage',
        'LINE\LINEBot\Event\PostbackEvent' => 'PostbackEvent',
        'LINE\LINEBot\Event\ThingsEvent' => 'ThingsEvent',
        'LINE\LINEBot\Event\UnfollowEvent' => 'UnfollowEvent',
        'LINE\LINEBot\Event\UnknownEvent' => 'UnknownEvent'
    );
}

?>
