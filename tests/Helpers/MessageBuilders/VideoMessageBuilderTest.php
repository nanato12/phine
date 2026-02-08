<?php

namespace Phine\Tests\Helpers\MessageBuilders;

use LINE\Constants\MessageType;
use Phine\Helpers\MessageBuilders\VideoMessageBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class VideoMessageBuilderTest extends TestCase
{
    #[Test]
    public function constructWithoutTrackingId(): void
    {
        $builder = new VideoMessageBuilder(
            'https://example.com/video.mp4',
            'https://example.com/preview.jpg'
        );

        $this->assertSame(MessageType::VIDEO, $builder->getType());
        $this->assertSame('https://example.com/video.mp4', $builder->getOriginalContentUrl());
        $this->assertSame('https://example.com/preview.jpg', $builder->getPreviewImageUrl());
        $this->assertNull($builder->getTrackingId());
    }

    #[Test]
    public function constructWithTrackingId(): void
    {
        $builder = new VideoMessageBuilder(
            'https://example.com/video.mp4',
            'https://example.com/preview.jpg',
            'tracking-123'
        );

        $this->assertSame('tracking-123', $builder->getTrackingId());
    }
}
