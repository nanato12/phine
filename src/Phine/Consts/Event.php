<?php

/*

Copyright: nanato12

*/

namespace Phine\Consts;

class Event
{
    // ACCOUNT EVENT
    const ACCOUNT_LINK = 'AccountLinkEvent';
    const BEACON_DETECTION = 'BeaconDetectionEvent';
    const THINGS = 'ThingsEvent';

    // BOT EVENT
    const FOLLOW = 'FollowEvent';
    const UNFOLLOW = 'UnfollowEvent';
    const POSTBACK = 'PostbackEvent';

    // GROUP | ROOM EVENT
    const JOIN = 'JoinEvent';
    const LEAVE = 'LeaveEvent';
    const MEMBER_JOIN = 'MemberJoinEvent';
    const MEMBER_LEAVE = 'MemberLeaveEvent';

    // MESSAGE EVENT
    const MESSAGE = 'MessageEvent';
    const TEXT_MESSAGE = 'TextMessage';
    const IMAGE_MESSAGE = 'ImageMessage';
    const VIDEO_MESSAGE = 'VideoMessage';
    const AUDIO_MESSAGE = 'AudioMessage';
    const FILE_MESSAGE = 'FileMessage';
    const STICKER_MESSAGE = 'StickerMessage';
    const LOCATION_MESSAGE = 'LocationMessage';
    const UNKNOWN_MESSAGE = 'UnknownMessage';
    const UNSEND_MESSAGE = 'UnsendEvent';

    // OTHER
    const VIDEO_PLAY_COMPLETE = 'VideoPlayCompleteEvent';
    const UNKNOWN = 'UnknownEvent';
}
