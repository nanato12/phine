<?php

namespace Phine;

use GuzzleHttp\Client as GuzzleHttpClient;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Model\ErrorResponse;
use LINE\Clients\MessagingApi\Model\Message;
use LINE\Clients\MessagingApi\Model\QuickReply;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\ReplyMessageResponse;
use LINE\Clients\MessagingApi\Model\Sender;
use LINE\Constants\EventSourceType;
use LINE\Parser\EventRequestParser;
use LINE\Parser\Exception\InvalidEventSourceException;
use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\FollowEvent;
use LINE\Webhook\Model\GroupSource;
use LINE\Webhook\Model\JoinEvent;
use LINE\Webhook\Model\MemberJoinedEvent;
use LINE\Webhook\Model\MessageEvent;
use LINE\Webhook\Model\PostbackEvent;
use LINE\Webhook\Model\RoomSource;
use Phine\Exceptions\NullReplyTokenException;
use Phine\Objects\Profile;

/**
 * MessagingApiApi Wrapper class.
 */
class Client extends MessagingApiApi
{
    /** @var Event webhook event */
    public $event;

    /** @var null|string webhook event reply token */
    private $replyToken = null;

    /** @var string line bot chaneel secret */
    private $channelAccessSecret;

    public function __construct(string $channelAccessSecret, string $channelAccessToken)
    {
        $this->channelAccessSecret = $channelAccessSecret;

        $client = new GuzzleHttpClient();
        $config = (new Configuration())
            ->setAccessToken($channelAccessToken);

        parent::__construct(
            client: $client,
            config: $config,
        );
    }

    /**
     * Function to parse from http request body to event.
     *
     * @param string $body      http request body
     * @param string $signature http request header x-line-signature
     *
     * @return Event[]
     */
    public function parseEventRequest(string $body, string $signature): array
    {
        return EventRequestParser::parseEventRequest(
            body: $body,
            channelSecret: $this->channelAccessSecret,
            signature: $signature,
        )->getEvents();
    }

    /**
     * Function to send a reply message.
     *
     * @param Message[] $messages
     * @param Sender|null $sender sender
     * @param QuickReply|null $quickReply quickReply
     *
     * @throws NullReplyTokenException
     */
    public function reply(
        array $messages,
        ?Sender $sender = null,
        ?QuickReply $quickReply = null
    ): ErrorResponse|ReplyMessageResponse {
        if (is_null($this->replyToken)) {
            throw new NullReplyTokenException('reply token is null.');
        }

        if (!is_null($sender)) {
            $messages = array_map(
                function (Message $m) use ($sender): Message {
                    return $m->setSender($sender);
                },
                $messages
            );
        }

        if (!is_null($quickReply)) {
            $messages = array_map(
                function (Message $m) use ($quickReply): Message {
                    return $m->setQuickReply($quickReply);
                },
                $messages
            );
        }

        $request = (new ReplyMessageRequest())
            ->setReplyToken($this->replyToken)
            ->setMessages($messages);

        return parent::replyMessage($request);
    }

    /**
     * Function to set event information and replay token to an instance based on an event.
     *
     * @param Event $event イベント
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;

        if (
            $event instanceof MessageEvent
            || $event instanceof FollowEvent
            || $event instanceof JoinEvent
            || $event instanceof MemberJoinedEvent
            || $event instanceof PostbackEvent
        ) {
            $this->replyToken = $event->getReplyToken();
        }
    }

    /**
     * Function to retrieve a profile.
     *
     * @param string $userID user id
     *
     * @return null|Profile user profile
     */
    public function getProfileFromUserID(string $userID): ?Profile
    {
        $source = $this->event->getSource();

        if (is_null($source)) {
            return null;
        }

        switch ($source->getType()) {
            case EventSourceType::USER:
                $r = $this->getProfile($userID);
                break;

            case EventSourceType::GROUP:
                /** @var GroupSource $source */
                $r = $this->getGroupMemberProfile($source->getGroupId(), $userID);
                break;

            case EventSourceType::ROOM:
                /** @var RoomSource $source */
                $r = $this->getRoomMemberProfile($source->getRoomId(), $userID);
                break;

            default:
                throw new InvalidEventSourceException(
                    sprintf('"%s" is invalid event source type.', $source->getType())
                );
        }

        return Profile::parseFromResponse($r);
    }
}
