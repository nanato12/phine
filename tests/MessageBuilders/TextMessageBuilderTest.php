<?php

namespace Phine\Tests\MessageBuilders;

use LINE\Clients\MessagingApi\Model\Emoji;
use LINE\Constants\MessageType;
use Phine\MessageBuilders\TextMessageBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class TextMessageBuilderTest extends TestCase
{
    #[Test]
    public function constructWithTextOnly(): void
    {
        $builder = new TextMessageBuilder('Hello World');

        $this->assertSame('Hello World', $builder->getText());
        $this->assertSame(MessageType::TEXT, $builder->getType());
        $this->assertNull($builder->getEmojis());
        $this->assertNull($builder->getQuoteToken());
    }

    #[Test]
    public function constructWithEmojis(): void
    {
        $emoji = new Emoji([
            'index' => 0,
            'productId' => '5ac1bfd5040ab15980c9b435',
            'emojiId' => '001',
        ]);

        $builder = new TextMessageBuilder('$ Hello', [$emoji]);

        $this->assertSame('$ Hello', $builder->getText());
        $this->assertCount(1, $builder->getEmojis());
    }

    #[Test]
    public function constructWithQuoteToken(): void
    {
        $builder = new TextMessageBuilder('Reply message', [], 'quote-token-123');

        $this->assertSame('Reply message', $builder->getText());
        $this->assertSame('quote-token-123', $builder->getQuoteToken());
    }

    #[Test]
    public function constructWithAllOptions(): void
    {
        $emoji = new Emoji([
            'index' => 0,
            'productId' => '5ac1bfd5040ab15980c9b435',
            'emojiId' => '001',
        ]);

        $builder = new TextMessageBuilder('$ Hello', [$emoji], 'quote-token-456');

        $this->assertSame('$ Hello', $builder->getText());
        $this->assertCount(1, $builder->getEmojis());
        $this->assertSame('quote-token-456', $builder->getQuoteToken());
    }
}
