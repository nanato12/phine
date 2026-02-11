<?php

namespace Phine;

use GuzzleHttp\Client as GuzzleHttpClient;
use LINE\Clients\MessagingApi\Api\MessagingApiApi;
use LINE\Clients\MessagingApi\Configuration;
use LINE\Clients\MessagingApi\Model\BroadcastRequest;
use LINE\Clients\MessagingApi\Model\ErrorResponse;
use LINE\Clients\MessagingApi\Model\Message;
use LINE\Clients\MessagingApi\Model\MulticastRequest;
use LINE\Clients\MessagingApi\Model\PushMessageRequest;
use LINE\Clients\MessagingApi\Model\PushMessageResponse;
use LINE\Clients\MessagingApi\Model\QuickReply;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\ReplyMessageResponse;
use LINE\Clients\MessagingApi\Model\Sender;
use LINE\Constants\EventSourceType;
use LINE\Parser\EventRequestParser;
use LINE\Parser\Exception\InvalidEventSourceException;
use LINE\Webhook\Model\AccountLinkEvent;
use LINE\Webhook\Model\BeaconEvent;
use LINE\Webhook\Model\Event;
use LINE\Webhook\Model\FollowEvent;
use LINE\Webhook\Model\GroupSource;
use LINE\Webhook\Model\JoinEvent;
use LINE\Webhook\Model\MemberJoinedEvent;
use LINE\Webhook\Model\MessageEvent;
use LINE\Webhook\Model\PostbackEvent;
use LINE\Webhook\Model\RoomSource;
use LINE\Webhook\Model\VideoPlayCompleteEvent;
use Phine\DTO\Profile;
use Phine\Exceptions\NullReplyTokenException;

/**
 * MessagingApiApi Wrapper class.
 */
class Client extends MessagingApiApi
{
    public ?Event $event = null;

    private ?string $replyToken = null;

    private string $channelAccessSecret;

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
     * Parse webhook request body to events.
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
     * Send a reply message.
     *
     * @param Message[]       $messages
     * @param null|Sender     $sender     sender
     * @param null|QuickReply $quickReply quickReply
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

        $messages = $this->applyMessageOptions($messages, $sender, $quickReply);

        $request = (new ReplyMessageRequest())
            ->setReplyToken($this->replyToken)
            ->setMessages($messages);

        return parent::replyMessage($request);
    }

    /**
     * Send a push message.
     *
     * @param string          $to         recipient user/group/room id
     * @param Message[]       $messages
     * @param null|Sender     $sender     sender
     * @param null|QuickReply $quickReply quickReply
     */
    public function push(
        string $to,
        array $messages,
        ?Sender $sender = null,
        ?QuickReply $quickReply = null
    ): ErrorResponse|PushMessageResponse {
        $messages = $this->applyMessageOptions($messages, $sender, $quickReply);

        $request = (new PushMessageRequest())
            ->setTo($to)
            ->setMessages($messages);

        return parent::pushMessage($request);
    }

    /**
     * Send a multicast message.
     *
     * @param string[]        $to         recipient user ids (max 500)
     * @param Message[]       $messages
     * @param null|Sender     $sender     sender
     * @param null|QuickReply $quickReply quickReply
     */
    public function sendMulticast(
        array $to,
        array $messages,
        ?Sender $sender = null,
        ?QuickReply $quickReply = null
    ): object {
        $messages = $this->applyMessageOptions($messages, $sender, $quickReply);

        $request = (new MulticastRequest())
            ->setTo($to)
            ->setMessages($messages);

        return parent::multicast($request);
    }

    /**
     * Send a broadcast message.
     *
     * @param Message[]       $messages
     * @param null|Sender     $sender     sender
     * @param null|QuickReply $quickReply quickReply
     */
    public function sendBroadcast(
        array $messages,
        ?Sender $sender = null,
        ?QuickReply $quickReply = null
    ): object {
        $messages = $this->applyMessageOptions($messages, $sender, $quickReply);

        $request = (new BroadcastRequest())
            ->setMessages($messages);

        return parent::broadcast($request);
    }

    /**
     * Set event information and reply token.
     *
     * @param Event $event event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
        $this->replyToken = null;

        if (
            $event instanceof MessageEvent
            || $event instanceof FollowEvent
            || $event instanceof JoinEvent
            || $event instanceof MemberJoinedEvent
            || $event instanceof PostbackEvent
            || $event instanceof BeaconEvent
            || $event instanceof AccountLinkEvent
            || $event instanceof VideoPlayCompleteEvent
        ) {
            $this->replyToken = $event->getReplyToken();
        }
    }

    /**
     * Retrieve a user profile.
     *
     * Automatically uses the appropriate API based on event source.
     *
     * @param string $userID user id
     *
     * @return null|Profile user profile
     */
    public function getProfileFromUserID(string $userID): ?Profile
    {
        if (is_null($this->event)) {
            $r = $this->getProfile($userID);

            return Profile::parseFromResponse($r);
        }

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

    /**
     * Apply sender and quickReply options to messages.
     *
     * @param Message[] $messages
     *
     * @return Message[]
     */
    private function applyMessageOptions(
        array $messages,
        ?Sender $sender,
        ?QuickReply $quickReply
    ): array {
        if (!is_null($sender)) {
            $messages = array_map(
                fn (Message $m): Message => $m->setSender($sender),
                $messages
            );
        }

        if (!is_null($quickReply)) {
            $messages = array_map(
                fn (Message $m): Message => $m->setQuickReply($quickReply),
                $messages
            );
        }

        return $messages;
    }
}
