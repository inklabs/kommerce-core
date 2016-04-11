<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentCarrierTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(ShipmentCarrierType::unknown()->isUnknown());
        $this->assertTrue(ShipmentCarrierType::ups()->isUps());
        $this->assertTrue(ShipmentCarrierType::usps()->isUsps());
        $this->assertTrue(ShipmentCarrierType::fedex()->isFedex());
    }

    public function testGetters()
    {
        $this->assertSame('Unknown', ShipmentCarrierType::unknown()->getName());
        $this->assertSame('UPS', ShipmentCarrierType::ups()->getName());
        $this->assertSame('USPS', ShipmentCarrierType::usps()->getName());
        $this->assertSame('FedEx', ShipmentCarrierType::fedex()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(ShipmentCarrierType::createById(ShipmentCarrierType::UNKNOWN)->isUnknown());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        ShipmentCarrierType::createById(999);
    }
}
