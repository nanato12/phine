<?php

namespace Phine\Tests\DTO;

use LINE\Clients\MessagingApi\Model\GroupUserProfileResponse;
use LINE\Clients\MessagingApi\Model\RoomUserProfileResponse;
use LINE\Clients\MessagingApi\Model\UserProfileResponse;
use Phine\DTO\Profile;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    #[Test]
    public function parseFromUserProfileResponse(): void
    {
        $response = new UserProfileResponse([
            'displayName' => 'Test User',
            'userId' => 'U1234567890',
            'pictureUrl' => 'https://example.com/picture.jpg',
            'statusMessage' => 'Hello World',
            'language' => 'ja',
        ]);

        $profile = Profile::parseFromResponse($response);

        $this->assertSame('Test User', $profile->displayName);
        $this->assertSame('U1234567890', $profile->userId);
        $this->assertSame('https://example.com/picture.jpg', $profile->pictureUrl);
        $this->assertSame('Hello World', $profile->statusMessage);
        $this->assertSame('ja', $profile->language);
    }

    #[Test]
    public function parseFromGroupUserProfileResponse(): void
    {
        $response = new GroupUserProfileResponse([
            'displayName' => 'Group User',
            'userId' => 'U0987654321',
            'pictureUrl' => 'https://example.com/group-picture.jpg',
        ]);

        $profile = Profile::parseFromResponse($response);

        $this->assertSame('Group User', $profile->displayName);
        $this->assertSame('U0987654321', $profile->userId);
        $this->assertSame('https://example.com/group-picture.jpg', $profile->pictureUrl);
        $this->assertNull($profile->statusMessage);
        $this->assertNull($profile->language);
    }

    #[Test]
    public function parseFromRoomUserProfileResponse(): void
    {
        $response = new RoomUserProfileResponse([
            'displayName' => 'Room User',
            'userId' => 'U1111111111',
            'pictureUrl' => null,
        ]);

        $profile = Profile::parseFromResponse($response);

        $this->assertSame('Room User', $profile->displayName);
        $this->assertSame('U1111111111', $profile->userId);
        $this->assertNull($profile->pictureUrl);
        $this->assertNull($profile->statusMessage);
        $this->assertNull($profile->language);
    }
}
