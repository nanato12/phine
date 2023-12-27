<?php

namespace Phine\Objects;

use LINE\Clients\MessagingApi\Model\GroupUserProfileResponse;
use LINE\Clients\MessagingApi\Model\RoomUserProfileResponse;
use LINE\Clients\MessagingApi\Model\UserProfileResponse;

/**
 * LINE user profile class.
 */
final class Profile
{
    /** @var string */
    public $displayName;

    /** @var string */
    public $userId;

    /** @var null|string */
    public $pictureUrl;

    /** @var null|string */
    public $statusMessage;

    /** @var null|string */
    public $language;

    /**
     * parse from user profile response.
     *
     * @param GroupUserProfileResponse|RoomUserProfileResponse|UserProfileResponse $r response
     */
    public static function parseFromResponse(
        GroupUserProfileResponse|RoomUserProfileResponse|UserProfileResponse $r
    ): self {
        $p = new self();
        $p->displayName = $r->getDisplayName();
        $p->userId = $r->getUserId();
        $p->pictureUrl = $r->getPictureUrl();

        if ($r instanceof UserProfileResponse) {
            $p->statusMessage = $r->getStatusMessage();
            $p->language = $r->getLanguage();
        }

        return $p;
    }
}
