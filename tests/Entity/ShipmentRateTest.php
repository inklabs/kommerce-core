<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentRateTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipmentRate = new ShipmentRate(new Money(907, 'USD'));
        $shipmentRate->setExternalId('rate_04f9a67abcb54511b756254e3b72a48z');
        $shipmentRate->setCarrier('UPS');
        $shipmentRate->setService('Ground');
        $shipmentRate->setListRate(new Money(986, 'USD'));
        $shipmentRate->setRetailRate(new Money(1196, 'USD'));
        $shipmentRate->setDeliveryDate(new DateTime);
        $shipmentRate->setIsDeliveryDateGuaranteed(true);
        $shipmentRate->setDeliveryDays(5);
        $shipmentRate->setEstDeliveryDays(5);

        $this->assertEntityValid($shipmentRate);
        $this->assertSame('rate_04f9a67abcb54511b756254e3b72a48z', $shipmentRate->getExternalId());
        $this->assertSame('UPS', $shipmentRate->getCarrier());
        $this->assertSame('Ground', $shipmentRate->getService());
        $this->assertSame(907, $shipmentRate->getRate()->getAmount());
        $this->assertSame(986, $shipmentRate->getListRate()->getAmount());
        $this->assertSame(1196, $shipmentRate->getRetailRate()->getAmount());
        $this->assertTrue($shipmentRate->getDeliveryDate() instanceof DateTime);
        $this->assertSame(5, $shipmentRate->getDeliveryDays());
        $this->assertSame(true, $shipmentRate->isDeliveryDateGuaranteed());
        $this->assertSame(5, $shipmentRate->getEstDeliveryDays());
    }
}
