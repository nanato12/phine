<?php

namespace Phine\Tests\Helpers\MessageBuilders;

use LINE\Constants\MessageType;
use Phine\Helpers\MessageBuilders\ImageMessageBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ImageMessageBuilderTest extends TestCase
{
    #[Test]
    public function construct(): void
    {
        $builder = new ImageMessageBuilder(
            'https://example.com/original.jpg',
            'https://example.com/preview.jpg'
        );

        $this->assertSame(MessageType::IMAGE, $builder->getType());
        $this->assertSame('https://example.com/original.jpg', $builder->getOriginalContentUrl());
        $this->assertSame('https://example.com/preview.jpg', $builder->getPreviewImageUrl());
    }
}
