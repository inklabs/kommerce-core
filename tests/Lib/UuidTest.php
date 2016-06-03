<?php
namespace inklabs\kommerce\Lib;

use Hamcrest\AssertionError;
use Hamcrest\MatcherAssert;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class UuidTest extends EntityTestCase
{
    const UUID4_STRING = '797b318d-52dc-4084-9051-adf7e9ed1618';
    const UUID4_HEX_STRING = '797b318d52dc40849051adf7e9ed1618';
    const UUID1_STRING = '1fa16d7c-29c6-11e6-b67b-9e71128cae77';

    public function testFromString()
    {
        $uuid = Uuid::fromString(self::UUID4_STRING);

        $this->assertTrue($uuid instanceof Uuid);
        $this->assertSame(self::UUID4_STRING, $uuid->toString());
        $this->assertSame(self::UUID4_STRING, $uuid->__toString());
        $this->assertSame(self::UUID4_STRING, (string) $uuid);
        $this->assertSame(self::UUID4_STRING, $uuid->jsonSerialize());
        $this->assertSame(self::UUID4_STRING, $uuid->serialize());
    }

    public function testCompareTo()
    {
        $uuid1 = Uuid::fromString(self::UUID4_STRING);
        $uuid2 = Uuid::fromString(self::UUID4_STRING);

        $this->assertEquals(0, $uuid1->compareTo($uuid2));
        $this->assertEquals(0, $uuid2->compareTo($uuid1));
    }

    public function testEquals()
    {
        $uuid1 = Uuid::fromString(self::UUID4_STRING);
        $uuid2 = Uuid::fromString(self::UUID4_STRING);

        $this->assertTrue($uuid1->equals($uuid2));
        $this->assertFalse($uuid1->equals(null));
    }

    public function testGetHex()
    {
        $uuid1 = Uuid::fromString(self::UUID4_STRING);
        $this->assertSame(self::UUID4_HEX_STRING, $uuid1->getHex());
    }

    public function testMatches()
    {
        $uuid1 = Uuid::fromString(self::UUID4_STRING);
        $uuid2 = Uuid::fromString(self::UUID4_STRING);

        $this->assertTrue($uuid1->matches($uuid2));
    }

    public function testSerialize()
    {
        $uuid1 = Uuid::fromString(self::UUID4_STRING);
        $serializedString = $uuid1->serialize();

        $uuid2 = Uuid::uuid4();
        $uuid2->unserialize($serializedString);

        $this->assertTrue($uuid1->equals($uuid2));
    }

    public function testFromBytes()
    {
        $uuid1 = Uuid::fromString(self::UUID4_STRING);
        $bytes = $uuid1->getBytes();

        $uuid2 = Uuid::fromBytes($bytes);

        $this->assertTrue($uuid1->equals($uuid2));
    }

    public function testHamcrestMatcher()
    {
        $uuid1 = Uuid::fromString(self::UUID4_STRING);
        $uuid2 = Uuid::fromString(self::UUID1_STRING);

        MatcherAssert::assertThat($uuid1, $uuid1);

        $this->setExpectedException(
            AssertionError::class,
            'Expected: "' . self::UUID1_STRING . '"' . PHP_EOL .
            '     but: was "' . self::UUID4_STRING . '"'
        );

        MatcherAssert::assertThat($uuid1, $uuid2);
    }
}
