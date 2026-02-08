<?php

namespace Phine\Tests\MessageBuilders;

use LINE\Constants\MessageType;
use Phine\MessageBuilders\RawFlexMessageBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RawFlexMessageBuilderTest extends TestCase
{
    #[Test]
    public function constructWithBubbleContent(): void
    {
        $contents = [
            'type' => 'bubble',
            'body' => [
                'type' => 'box',
                'layout' => 'vertical',
                'contents' => [
                    [
                        'type' => 'text',
                        'text' => 'Hello, World!',
                    ],
                ],
            ],
        ];

        $builder = new RawFlexMessageBuilder($contents);

        $this->assertSame(MessageType::FLEX, $builder->getType());
        $this->assertSame('Flex Message', $builder->getAltText());
        $this->assertSame($contents, $builder->getContents());
    }

    #[Test]
    public function constructWithCustomAltText(): void
    {
        $contents = [
            'type' => 'bubble',
            'body' => [
                'type' => 'box',
                'layout' => 'vertical',
                'contents' => [],
            ],
        ];

        $builder = new RawFlexMessageBuilder($contents, 'Custom Alt Text');

        $this->assertSame('Custom Alt Text', $builder->getAltText());
    }

    #[Test]
    public function constructWithCarouselContent(): void
    {
        $contents = [
            'type' => 'carousel',
            'contents' => [
                [
                    'type' => 'bubble',
                    'body' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [],
                    ],
                ],
                [
                    'type' => 'bubble',
                    'body' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [],
                    ],
                ],
            ],
        ];

        $builder = new RawFlexMessageBuilder($contents, 'Carousel Message');

        $this->assertSame($contents, $builder->getContents());
        $this->assertSame('Carousel Message', $builder->getAltText());
    }
}
