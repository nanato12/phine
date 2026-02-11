<?php

namespace Phine\Tests\MessageBuilders;

use LINE\Constants\MessageType;
use Phine\MessageBuilders\LocationMessageBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class LocationMessageBuilderTest extends TestCase
{
    #[Test]
    public function construct(): void
    {
        $builder = new LocationMessageBuilder(
            'Tokyo Station',
            '1 Chome Marunouchi, Chiyoda City, Tokyo',
            35.6812,
            139.7671
        );

        $this->assertSame(MessageType::LOCATION, $builder->getType());
        $this->assertSame('Tokyo Station', $builder->getTitle());
        $this->assertSame('1 Chome Marunouchi, Chiyoda City, Tokyo', $builder->getAddress());
        $this->assertSame(35.6812, $builder->getLatitude());
        $this->assertSame(139.7671, $builder->getLongitude());
    }
}
