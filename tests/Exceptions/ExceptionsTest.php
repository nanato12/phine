<?php

namespace Phine\Tests\Exceptions;

use Exception;
use Phine\Exceptions\InvalidHandlerClassException;
use Phine\Exceptions\NoDefinedException;
use Phine\Exceptions\NullReplyTokenException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class ExceptionsTest extends TestCase
{
    #[Test]
    public function invalidHandlerClassExceptionExtendsException(): void
    {
        $exception = new InvalidHandlerClassException('Test message');

        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertSame('Test message', $exception->getMessage());
    }

    #[Test]
    public function noDefinedExceptionExtendsException(): void
    {
        $exception = new NoDefinedException('Not defined');

        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertSame('Not defined', $exception->getMessage());
    }

    #[Test]
    public function nullReplyTokenExceptionExtendsException(): void
    {
        $exception = new NullReplyTokenException('Token is null');

        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertSame('Token is null', $exception->getMessage());
    }
}
