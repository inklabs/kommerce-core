<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OptionTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(OptionType::select()->isSelect());
        $this->assertTrue(OptionType::radio()->isRadio());
        $this->assertTrue(OptionType::checkbox()->isCheckbox());
    }

    public function testGetters()
    {
        $this->assertSame('Select', OptionType::select()->getName());
        $this->assertSame('Radio', OptionType::radio()->getName());
        $this->assertSame('Checkbox', OptionType::checkbox()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(OptionType::createById(OptionType::SELECT)->isSelect());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        OptionType::createById(999);
    }
}
