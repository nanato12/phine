<?

/*

Create referring to here
https://line.github.io/line-bot-sdk-php/class-LINE.LINEBot.html

Copyright: nanato12

*/

namespace Phine;

use LINE\LINEBot\MessageBuilder\RawMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;

class Service {

    function __construct($client){
        $this->client = $client->client;
    }

    // main function
    function getProfile($userId){
        return $this->client->getProfile($userId);
    }
    function getProfileFromGroup($groupId, $userId){
        return $this->client->getGroupMemberProfile($groupId, $userId);
    }
    function getProfileFromRoom($roomId, $userId){
        return $this->client->getRoomMemberProfile($roomId, $userId);
    }
    function getGroupMemberIds($groupId, $start=null){
        return $this->client->getGroupMemberIds($groupId, $start=null);
    }
    function getRoomMemberIds($roomId, $start=null){
        return $this->client->getRoomMemberIds($roomId, $start=null);
    }
    function getAllGroupMemberIds($groupId){
        return $this->client->getAllGroupMemberIds($groupId);
    }
    function getAllRoomMemberIds($roomId){
        return $this->client->getAllRoomMemberIds($roomId);
    }
    function getMessageContent($messageId){
        return $this->client->getMessageContent($messageId);
    }

    // send message function
    function replyTextMessage($replyToken, $text){
        return $this->client->replyText(
            $replyToken,
            $text
        );
    }
    function replyFlexMessage($replyToken, $flexContent){
        return $this->client->replyMessage(
            $replyToken,
            new RawMessageBuilder($flexContent)
        );
    }
    function replyImageMessage($replyToken, $imageUrl){
        return $this->client->replyMessage(
            $replyToken,
            new ImageMessageBuilder($imageUrl, $imageUrl)
        );
    }
    function replyVideoMessage($replyToken, $contentUrl, $previewUrl){
        return $this->client->replyMessage(
            $replyToken,
            new VideoMessageBuilder($contentUrl, $previewUrl)
        );
    }
    function replyStickerMessage($replyToken, $packageId, $stickerId){
        return $this->client->replyMessage(
            $replyToken,
            new StickerMessageBuilder($packageId, $stickerId)
        );
    }
    function pushMessage($to, $message){
        return $this->client->pushMessage($to, $message);
    }
    function multicast($toList, $message){
        return $this->client->multicast($toList, $message);
    }
    function broadcast($message){
        return $this->client->broadcast($message);
    }

    // bot action
    function leaveGroup($groupId){
        return $this->client->leaveGroup($groupId);
    }
    function leaveRoom($roomId){
        return $this->client->leaveRoom($roomId);
    }

    // rich menu
    function getRichMenu($richMenuId){
        return $this->client->getRichMenu($richMenuId);
    }
    function createRichMenu($richMenu){
        return $this->client->createRichMenu($richMenu);
    }
    function deleteRichMenu($richMenuId){
        return $this->client->deleteRichMenu($richMenuId);
    }
    function setDefaultRichMenuId($richMenuId){
        return $this->client->setDefaultRichMenuId($richMenuId);
    }
    function getDefaultRichMenuId(){
        return $this->client->getDefaultRichMenuId();
    }
    function cancelDefaultRichMenuId(){
        return $this->client->cancelDefaultRichMenuId();
    }
    function getRichMenuId($userId){
        return $this->client->getRichMenuId($userId);
    }
    function linkRichMenu($userId, $richMenuId){
        return $this->client->linkRichMenu($userId, $richMenuId);
    }
    function bulkLinkRichMenu($userIds, $richMenuId){
        return $this->client->bulkLinkRichMenu($userIds, $richMenuId);
    }
    function unlinkRichMenu($userId){
        return $this->client->unlinkRichMenu($userId);
    }
    function bulkUnlinkRichMenu($userIds){
        return $this->client->bulkUnlinkRichMenu($userIds);
    }
    function downloadRichMenuImage($richMenuId){
        return $this->client->downloadRichMenuImage($richMenuId);
    }
    function uploadRichMenuImage($richMenuId, $imagePath, $contentType){
        return $this->client->uploadRichMenuImage($richMenuId, $imagePath, $contentType);
    }
    function getRichMenuList(){
        return $this->client->getRichMenuList();
    }

    // token
    function createLinkToken($userId){
        return $this->client->createLinkToken($userId);
    }
    function createChannelAccessToken($channelId){
        return $this->client->createChannelAccessToken($channelId);
    }
    function revokeChannelAccessToken($channelAccessToken){
        return $this->client->revokeChannelAccessToken($channelAccessToken);
    }

    // event
    function parseEventRequest($body, $signature){
        return $this->client->parseEventRequest($body, $signature);
    }

    function validateSignature($body, $signature){
        return $this->client->validateSignature($body, $signature);
    }

    // get count
    function getNumberOfSentReplyMessages($datetime){
        return $this->client->getNumberOfSentReplyMessages($datetime);
    }
    function getNumberOfSentPushMessages($datetime){
        return $this->client->getNumberOfSentPushMessages($datetime);
    }
    function getNumberOfSentMulticastMessages($datetime){
        return $this->client->getNumberOfSentMulticastMessages($datetime);
    }
    function getNumberOfSentBroadcastMessages($datetime){
        return $this->client->getNumberOfSentBroadcastMessages($datetime);
    }
    function getNumberOfMessageDeliveries($datetime){
        return $this->client->getNumberOfMessageDeliveries($datetime);
    }
    function getNumberOfFollowers($datetime){
        return $this->client->getNumberOfFollowers($datetime);
    }
    function getSentMessageCountThisMonth(){
        return $this->client->getNumberOfSentThisMonth();
    }
    function getAddLimitCountThisMonth(){
        return $this->client->getNumberOfLimitForAdditional();
    }

    // other
    function getFriendDemographics(){
        return $this->client->getFriendDemographics();
    }
    function getUserInteractionStatistics($requestId){
        return $this->client->getUserInteractionStatistics($requestId);
    }

    function sendNarrowcast($message, $recipient=NULL, $demographicFilter=NULL, $limit=NULL){
        return $this->client->sendNarrowcast($message, $recipient=NULL, $demographicFilter=NULL, $limit=NULL);
    }
    function getNarrowcastProgress($requestId){
        return $this->client->getNarrowcastProgress($requestId);
    }
}

?>
