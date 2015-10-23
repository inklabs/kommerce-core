<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentRateTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipmentRate = new ShipmentRate(225);
        $shipmentRate->setService('First');
        $shipmentRate->setCarrier('USPS');
        $shipmentRate->setExternalId('rate_nyCb6ubX');
        $shipmentRate->setCreated(new DateTime);

        $this->assertEntityValid($shipmentRate);
        $this->assertSame(225, $shipmentRate->getRate());
        $this->assertSame('USD', $shipmentRate->getCurrency());
        $this->assertSame('First', $shipmentRate->getService());
        $this->assertSame('USPS', $shipmentRate->getCarrier());
        $this->assertSame('rate_nyCb6ubX', $shipmentRate->getExternalId());
        $this->assertNotSame(null, $shipmentRate->getCreated());
    }
}
