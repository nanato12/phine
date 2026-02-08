<?php

namespace Phine\Tests\MessageBuilders;

use LINE\Constants\MessageType;
use Phine\MessageBuilders\StickerMessageBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StickerMessageBuilderTest extends TestCase
{
    #[Test]
    public function constructWithoutQuoteToken(): void
    {
        $builder = new StickerMessageBuilder('446', '1988');

        $this->assertSame(MessageType::STICKER, $builder->getType());
        $this->assertSame('446', $builder->getPackageId());
        $this->assertSame('1988', $builder->getStickerId());
        $this->assertNull($builder->getQuoteToken());
    }

    #[Test]
    public function constructWithQuoteToken(): void
    {
        $builder = new StickerMessageBuilder('446', '1988', 'quote-token-123');

        $this->assertSame('quote-token-123', $builder->getQuoteToken());
    }
}
