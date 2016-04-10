<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class TextOptionTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(TextOptionType::text()->isText());
        $this->assertTrue(TextOptionType::textarea()->isTextarea());
        $this->assertTrue(TextOptionType::file()->isFile());
        $this->assertTrue(TextOptionType::date()->isDate());
        $this->assertTrue(TextOptionType::time()->isTime());
        $this->assertTrue(TextOptionType::dateTime()->isDateTime());
    }

    public function testGetters()
    {
        $this->assertSame('Text', TextOptionType::text()->getName());
        $this->assertSame('Textarea', TextOptionType::textarea()->getName());
        $this->assertSame('File', TextOptionType::file()->getName());
        $this->assertSame('Date', TextOptionType::date()->getName());
        $this->assertSame('Time', TextOptionType::time()->getName());
        $this->assertSame('DateTime', TextOptionType::dateTime()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(TextOptionType::createById(TextOptionType::TEXT)->isText());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        TextOptionType::createById(999);
    }
}
