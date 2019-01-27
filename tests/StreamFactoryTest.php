<?php

namespace Bitty\Tests\Http;

use Bitty\Http\StreamFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class StreamFactoryTest extends TestCase
{
    /**
     * @var StreamFactory
     */
    protected $fixture = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new StreamFactory();
    }

    public function testInstanceOf(): void
    {
        self::assertInstanceOf(StreamFactoryInterface::class, $this->fixture);
    }

    public function testCreateStream(): void
    {
        $message = uniqid();
        $actual  = $this->fixture->createStream($message);

        self::assertInstanceOf(StreamInterface::class, $actual);
        self::assertEquals($message, (string) $actual);
    }

    public function testCreateStreamFromFile(): void
    {
        $filename = __DIR__.'/bootstrap.php';
        $actual   = $this->fixture->createStreamFromFile($filename, 'r');

        self::assertInstanceOf(StreamInterface::class, $actual);
        self::assertEquals(file_get_contents($filename), (string) $actual);
    }

    public function testCreateStreamFromResource(): void
    {
        $filename = __DIR__.'/bootstrap.php';
        $resource = fopen($filename, 'r');
        if (false === $resource) {
            self::fail($e->getMessage());

            return;
        }

        $actual = $this->fixture->createStreamFromResource($resource);

        self::assertInstanceOf(StreamInterface::class, $actual);
        self::assertEquals(file_get_contents($filename), (string) $actual);
    }
}
