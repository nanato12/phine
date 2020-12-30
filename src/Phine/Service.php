<?php

/*

Bot service object

Copyright: nanato12

*/

namespace Phine;

use Exception;
use stdClass;
use Phine\Message;

class Service extends Message
{

    function __construct($client)
    {
        $this->client = $client->client;
    }

    function setReplyToken($replyToken)
    {
        $this->replyToken = $replyToken;
    }

    // main function
    function getProfileV2($userId)
    {
        $obj = $this->client->getProfile($userId);
        $profileInfo = json_decode($obj->getRawBody(), true);
        if (!array_key_exists('userId', $profileInfo)) {
            $profile = null;
        } else {
            $profile = new stdClass;
            $profile->id = $profileInfo['userId'];
            $profile->name = $profileInfo['displayName'];
            if (array_key_exists('language', $profileInfo)) {
                $profile->language = $profileInfo['language'];
            } else {
                $profile->pictureUrl = null;
            }
            if (array_key_exists('pictureUrl', $profileInfo)) {
                $profile->pictureUrl = $profileInfo['pictureUrl'];
            } else {
                $profile->pictureUrl = null;
            }
            if (array_key_exists('statusMessage', $profileInfo)) {
                $profile->statusMessage = $profileInfo['statusMessage'];
            } else {
                $profile->statusMessage = null;
            }
        }
        return $profile;
    }
    function getProfileFromGroupV2($groupId, $userId)
    {
        $obj = $this->client->getGroupMemberProfile($groupId, $userId);
        $profileInfo = json_decode($obj->getRawBody(), true);
        if (!array_key_exists('userId', $profileInfo)) {
            $profile = null;
        } else {
            $profile = new stdClass;
            $profile->id = $profileInfo['userId'];
            $profile->name = $profileInfo['displayName'];
            $profile->language = null;
            if (array_key_exists('pictureUrl', $profileInfo)) {
                $profile->pictureUrl = $profileInfo['pictureUrl'];
            } else {
                $profile->pictureUrl = null;
            }
            $profile->statusMessage = null;
        }
        return $profile;
    }
    function getProfileFromRoomV2($roomId, $userId)
    {
        $obj = $this->client->getRoomMemberProfile($roomId, $userId);
        $profileInfo = json_decode($obj->getRawBody(), true);
        if (!array_key_exists('userId', $profileInfo)) {
            $profile = null;
        } else {
            $profile = new stdClass;
            $profile->id = $profileInfo['userId'];
            $profile->name = $profileInfo['displayName'];
            $profile->language = null;
            if (array_key_exists('pictureUrl', $profileInfo)) {
                $profile->pictureUrl = $profileInfo['pictureUrl'];
            } else {
                $profile->pictureUrl = null;
            }
            $profile->statusMessage = null;
        }
        return $profile;
    }
    function getProfile($userId)
    {
        return $this->client->getProfile($userId);
    }
    function getProfileFromGroup($groupId, $userId)
    {
        return $this->client->getGroupMemberProfile($groupId, $userId);
    }
    function getProfileFromRoom($roomId, $userId)
    {
        return $this->client->getRoomMemberProfile($roomId, $userId);
    }
    function getGroup($groupId)
    {
        $obj = $this->getGroupSummary($groupId);
        $groupInfo = json_decode($obj->getRawBody(), true);
        $obj = $this->getGroupMembersCount($groupId);
        $groupInfo2 = json_decode($obj->getRawBody(), true);
        if (!array_key_exists('groupId', $groupInfo)) {
            $group = null;
        } else {
            $group = new stdClass;
            $group->id = $groupInfo['groupId'];
            $group->name = $groupInfo['groupName'];
            if (array_key_exists('pictureUrl', $groupInfo)) {
                $group->pictureUrl = $groupInfo['pictureUrl'];
            } else {
                $group->pictureUrl = null;
            }
            $group->membersCount = $groupInfo2['count'];
        }
        return $group;
    }
    function getGroupSummary($groupId)
    {
        return $this->client->getGroupSummary($groupId);
    }
    function getGroupMembersCount($groupId)
    {
        return $this->client->getGroupMembersCount($groupId);
    }
    function getGroupMemberIds($groupId, $start = null)
    {
        return $this->client->getGroupMemberIds($groupId, $start);
    }
    function getAllGroupMemberIds($groupId)
    {
        return $this->client->getAllGroupMemberIds($groupId);
    }
    function getRoomMembersCount($roomId)
    {
        return $this->client->getRoomMembersCount($roomId);
    }
    function getRoomMemberIds($roomId, $start = null)
    {
        return $this->client->getRoomMemberIds($roomId, $start);
    }
    function getAllRoomMemberIds($roomId)
    {
        return $this->client->getAllRoomMemberIds($roomId);
    }
    function getMessageContent($messageId)
    {
        return $this->client->getMessageContent($messageId);
    }
    function saveMessageContent($messageId, $fileName = null)
    {
        $content = $this->getMessageContent($messageId);
        $headers = $content->getHeaders();
        if (is_null($fileName)) {
            $fileInfo = explode('/', $headers['Content-Type']);
            $directory = $fileInfo[0];
            $extention = $fileInfo[1];
            if (!file_exists("content/${directory}")) {
                mkdir("content/${directory}", 0777, $recursive = true);
            }
            $fileName = "content/${directory}/${messageId}.${extention}";
        }
        file_put_contents($fileName, $content->getRawBody());
    }

    // send message function
    function replyMessage($messages)
    {
        if (count($messages) > 5) {
            throw new Exception('replyMessage: You can send up to 5 messages at once.');
        }
        return $this->client->replyMessage(
            $this->replyToken,
            $this->createMultiMessage($messages)
        );
    }
    function replyTextMessage(...$textArray)
    {
        $messages = [];
        foreach ($textArray as $text) {
            array_push($messages, $this->createTextMessage($text));
        }
        return $this->replyMessage($messages);
    }
    function replyImageMessage(...$imageUrlArray)
    {
        $messages = [];
        foreach ($imageUrlArray as $imageUrl) {
            array_push($messages, $this->createImageMessage($imageUrl));
        }
        return $this->replyMessage($messages);
    }
    function replyVideoMessage(...$videoContentArray)
    {
        $messages = [];
        foreach ($videoContentArray as $videoContent) {
            array_push($messages, $this->createVideoMessage($videoContent));
        }
        return $this->replyMessage($messages);
    }
    function replyAudioMessage(...$audioContentArray)
    {
        $messages = [];
        foreach ($audioContentArray as $audioContent) {
            array_push($messages, $this->createAudioMessage($audioContent));
        }
        return $this->replyMessage($messages);
    }
    function replyStickerMessage(...$stickerContentArray)
    {
        $messages = [];
        foreach ($stickerContentArray as $stickerContent) {
            array_push($messages, $this->createStickerMessage($stickerContent));
        }
        return $this->replyMessage($messages);
    }
    function replyLocationMessage(...$locationContentArray)
    {
        $messages = [];
        foreach ($locationContentArray as $locationContent) {
            array_push($messages, $this->createLocationMessage($locationContent));
        }
        return $this->replyMessage($messages);
    }
    function replyFlexMessage(...$flexContentArray)
    {
        $messages = [];
        foreach ($flexContentArray as $flexContent) {
            array_push($messages, $this->createFlexMessage($flexContent));
        }
        return $this->replyMessage($messages);
    }
    function replyRawMessage(...$rawContentArray)
    {
        $messages = [];
        foreach ($rawContentArray as $rawContent) {
            array_push($messages, $this->createRawMessage($rawContent));
        }
        return $this->replyMessage($messages);
    }
    function pushMessage($to, $message)
    {
        return $this->client->pushMessage($to, $message);
    }
    function multicast($toList, $message)
    {
        return $this->client->multicast($toList, $message);
    }
    function broadcast($message)
    {
        return $this->client->broadcast($message);
    }

    // bot action
    function leaveGroup($groupId)
    {
        return $this->client->leaveGroup($groupId);
    }
    function leaveRoom($roomId)
    {
        return $this->client->leaveRoom($roomId);
    }

    // rich menu
    function getRichMenu($richMenuId)
    {
        return $this->client->getRichMenu($richMenuId);
    }
    function createRichMenu($richMenu)
    {
        return $this->client->createRichMenu($richMenu);
    }
    function deleteRichMenu($richMenuId)
    {
        return $this->client->deleteRichMenu($richMenuId);
    }
    function setDefaultRichMenuId($richMenuId)
    {
        return $this->client->setDefaultRichMenuId($richMenuId);
    }
    function getDefaultRichMenuId()
    {
        return $this->client->getDefaultRichMenuId();
    }
    function cancelDefaultRichMenuId()
    {
        return $this->client->cancelDefaultRichMenuId();
    }
    function getRichMenuId($userId)
    {
        return $this->client->getRichMenuId($userId);
    }
    function linkRichMenu($userId, $richMenuId)
    {
        return $this->client->linkRichMenu($userId, $richMenuId);
    }
    function bulkLinkRichMenu($userIds, $richMenuId)
    {
        return $this->client->bulkLinkRichMenu($userIds, $richMenuId);
    }
    function unlinkRichMenu($userId)
    {
        return $this->client->unlinkRichMenu($userId);
    }
    function bulkUnlinkRichMenu($userIds)
    {
        return $this->client->bulkUnlinkRichMenu($userIds);
    }
    function downloadRichMenuImage($richMenuId)
    {
        return $this->client->downloadRichMenuImage($richMenuId);
    }
    function uploadRichMenuImage($richMenuId, $imagePath, $contentType)
    {
        return $this->client->uploadRichMenuImage($richMenuId, $imagePath, $contentType);
    }
    function getRichMenuList()
    {
        return $this->client->getRichMenuList();
    }

    // token
    function createLinkToken($userId)
    {
        return $this->client->createLinkToken($userId);
    }
    function createChannelAccessToken($channelId)
    {
        return $this->client->createChannelAccessToken($channelId);
    }
    function revokeChannelAccessToken($channelAccessToken)
    {
        return $this->client->revokeChannelAccessToken($channelAccessToken);
    }

    // event
    function parseEventRequest($body, $signature)
    {
        return $this->client->parseEventRequest($body, $signature);
    }

    function validateSignature($body, $signature)
    {
        return $this->client->validateSignature($body, $signature);
    }

    // get count
    function getNumberOfSentReplyMessages($datetime)
    {
        return $this->client->getNumberOfSentReplyMessages($datetime);
    }
    function getNumberOfSentPushMessages($datetime)
    {
        return $this->client->getNumberOfSentPushMessages($datetime);
    }
    function getNumberOfSentMulticastMessages($datetime)
    {
        return $this->client->getNumberOfSentMulticastMessages($datetime);
    }
    function getNumberOfSentBroadcastMessages($datetime)
    {
        return $this->client->getNumberOfSentBroadcastMessages($datetime);
    }
    function getNumberOfMessageDeliveries($datetime)
    {
        return $this->client->getNumberOfMessageDeliveries($datetime);
    }
    function getNumberOfFollowers($datetime)
    {
        return $this->client->getNumberOfFollowers($datetime);
    }
    function getSentMessageCountThisMonth()
    {
        return $this->client->getNumberOfSentThisMonth();
    }
    function getAddLimitCountThisMonth()
    {
        return $this->client->getNumberOfLimitForAdditional();
    }

    // other
    function getFriendDemographics()
    {
        return $this->client->getFriendDemographics();
    }
    function getUserInteractionStatistics($requestId)
    {
        return $this->client->getUserInteractionStatistics($requestId);
    }

    function sendNarrowcast($message, $recipient = NULL, $demographicFilter = NULL, $limit = NULL)
    {
        return $this->client->sendNarrowcast($message, $recipient, $demographicFilter, $limit);
    }
    function getNarrowcastProgress($requestId)
    {
        return $this->client->getNarrowcastProgress($requestId);
    }
}
