<?php

namespace Phine\DTO;

use LINE\Clients\MessagingApi\Model\GroupUserProfileResponse;
use LINE\Clients\MessagingApi\Model\RoomUserProfileResponse;
use LINE\Clients\MessagingApi\Model\UserProfileResponse;

/**
 * LINE user profile class.
 */
final class Profile
{
    public string $displayName;

    public string $userId;

    public ?string $pictureUrl = null;

    public ?string $statusMessage = null;

    public ?string $language = null;

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
