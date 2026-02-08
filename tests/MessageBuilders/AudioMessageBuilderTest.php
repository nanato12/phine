<?php

namespace Phine\Tests\MessageBuilders;

use LINE\Constants\MessageType;
use Phine\MessageBuilders\AudioMessageBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AudioMessageBuilderTest extends TestCase
{
    #[Test]
    public function construct(): void
    {
        $builder = new AudioMessageBuilder(
            'https://example.com/audio.m4a',
            60000
        );

        $this->assertSame(MessageType::AUDIO, $builder->getType());
        $this->assertSame('https://example.com/audio.m4a', $builder->getOriginalContentUrl());
        $this->assertSame(60000, $builder->getDuration());
    }
}
