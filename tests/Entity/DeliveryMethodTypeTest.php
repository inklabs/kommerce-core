<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class DeliveryMethodTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(DeliveryMethodType::standard()->isStandard());
        $this->assertTrue(DeliveryMethodType::oneDay()->isOneDay());
        $this->assertTrue(DeliveryMethodType::twoDay()->isTwoDay());
    }

    public function testGetters()
    {
        $this->assertSame('Standard', DeliveryMethodType::standard()->getName());
        $this->assertSame('One-Day', DeliveryMethodType::oneDay()->getName());
        $this->assertSame('Two-Day', DeliveryMethodType::twoDay()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(DeliveryMethodType::createById(DeliveryMethodType::STANDARD)->isStandard());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        DeliveryMethodType::createById(999);
    }

    public function testCreateByDeliveryDays()
    {
        $this->assertTrue(DeliveryMethodType::createByDeliveryDays(1)->isOneDay());
        $this->assertTrue(DeliveryMethodType::createByDeliveryDays(2)->isTwoDay());
        $this->assertTrue(DeliveryMethodType::createByDeliveryDays(3)->isStandard());
    }
}
