<?php

use LINE\LINEBot\Event\MessageEvent\TextMessage;
use Phine\Client;
use Phine\Structs\Profile;

function getQuickReplyContentByKey(string $key): array
{
    $quickItems = file_get_contents(__DIR__ . "/quick_reply.json");
    $content = json_decode($quickItems, true)[$key];
    return $content;
}

function getProfileByEvent(Client $client, TextMessage $event): ?Profile
{
    if ($event->isGroupEvent()) {
        $profile = $client->getProfileFromGroup(
            $event->getUserId(),
            $event->getGroupId()
        );
    } else if ($event->isRoomEvent()) {
        $profile = $client->getProfileFromRoom(
            $event->getUserId(),
            $event->getRoomId()
        );
    } else {
        $profile = $client->getProfileV2($event->getUserId());
    }
    return $profile;
}

function receiveTextMessage(Client $client, TextMessage $event)
{
    $text = $event->getText();

    // Reply message list
    $messages = [];

    switch ($text) {
        case "hey":
            // Reply text message
            array_push($messages, $client->createTextMessage("hey"));
            break;

        case "heyhey":
            // Reply multi text message
            array_push($messages, $client->createTextMessage("hey"));
            array_push($messages, $client->createTextMessage("hey"));
            break;

        case "me":
            // Reply user profile
            $profile = getProfileByEvent($client, $event);
            if (is_null($profile)) {
                array_push($messages, $client->createTextMessage("Not found."));
            } else {
                array_push($messages, $client->createTextMessage("Your information"));
                array_push($messages, $client->createTextMessage("uid: $profile->userId"));
                array_push($messages, $client->createTextMessage("name: $profile->displayName"));
                array_push($messages, $client->createTextMessage("icon: $profile->pictureUrl"));
            }
            break;

        case "group":
            // Reply group information
            if ($event->isGroupEvent()) {
                $group = $client->getGroup($event->getGroupId());
                array_push($messages, $client->createTextMessage("Group information"));
                array_push($messages, $client->createTextMessage("gid: $group->groupId"));
                array_push($messages, $client->createTextMessage("name: $group->groupName"));
                array_push($messages, $client->createTextMessage("icon: $group->pictureUrl"));
                array_push($messages, $client->createTextMessage("count: $group->count"));
            } else {
                array_push($messages, $client->createTextMessage("Here is not group."));
            }
            break;

        case "sender":
            $profile = getProfileByEvent($client, $event);
            $client->setSender($profile->displayName, $profile->pictureUrl);
            array_push($messages, $client->createTextMessage("hey"));
            break;

        case "quick":
            $quickReplyContent = getQuickReplyContentByKey("all_in");
            $client->setQuickReply($quickReplyContent);
            array_push($messages, $client->createTextMessage("hey"));
            break;
    }
    if (!empty($messages)) {
        $client->replyMessageV2($messages);
    }
}
