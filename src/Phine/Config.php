<?php

/*

Copyright: nanato12

*/

namespace Phine;

class Config {

    // ACCOUNT EVENT
    const EVENT_ACCOUNT_LINK = 'AccountLinkEvent';
    const EVENT_BEACON_DETECTION = 'BeaconDetectionEvent';
    const EVENT_THINGS = 'ThingsEvent';

    // BOT EVENT
    const EVENT_FOLLOW = 'FollowEvent';
    const EVENT_UNFOLLOW = 'UnfollowEvent';
    const EVENT_POSTBACK = 'PostbackEvent';

    // GROUP | ROOM EVENT
    const EVENT_JOIN = 'JoinEvent';
    const EVENT_LEAVE = 'LeaveEvent';
    const EVENT_MEMBER_JOIN = 'MemberJoinEvent';
    const EVENT_MEMBER_LEAVE = 'MemberLeaveEvent';

    // MESSAGE EVENT
    const EVENT_MESSAGE = 'MessageEvent';
    const EVENT_TEXT_MESSAGE = 'TextMessage';
    const EVENT_IMAGE_MESSAGE = 'ImageMessage';
    const EVENT_VIDEO_MESSAGE = 'VideoMessage';
    const EVENT_AUDIO_MESSAGE = 'AudioMessage';
    const EVENT_FILE_MESSAGE = 'FileMessage';
    const EVENT_STICKER_MESSAGE = 'StickerMessage';
    const EVENT_LOCATION_MESSAGE = 'LocationMessage';
    const EVENT_UNKNOWN_MESSAGE = 'UnknownMessage';
    const EVENT_UNSEND_MESSAGE = 'UnsendEvent';

    // OTHER
    const EVENT_VIDEO_PLAY_COMPLETE = 'VideoPlayCompleteEvent';
    const EVENT_UNKNOWN = 'UnknownEvent';
}

?>
