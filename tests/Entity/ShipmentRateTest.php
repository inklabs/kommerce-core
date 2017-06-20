<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class ShipmentRateTest extends EntityTestCase
{
    public function testCreate()
    {
        $rate = $this->dummyData->getMoney(907);
        $deliveryDate = new DateTime;

        $shipmentRate = new ShipmentRate($rate);
        $shipmentRate->setExternalId('rate_xxxxxx');
        $shipmentRate->setShipmentExternalId('shp_xxxxxx');
        $shipmentRate->setCarrier('UPS');
        $shipmentRate->setService('Ground');
        $shipmentRate->setListRate($this->dummyData->getMoney(986));
        $shipmentRate->setRetailRate($this->dummyData->getMoney(1196));
        $shipmentRate->setDeliveryDate($deliveryDate);
        $shipmentRate->setIsDeliveryDateGuaranteed(true);
        $shipmentRate->setDeliveryDays(5);
        $shipmentRate->setEstDeliveryDays(5);

        $this->assertEntityValid($shipmentRate);
        $this->assertSame('rate_xxxxxx', $shipmentRate->getExternalId());
        $this->assertSame('shp_xxxxxx', $shipmentRate->getShipmentExternalId());
        $this->assertSame('UPS', $shipmentRate->getCarrier());
        $this->assertSame('Ground', $shipmentRate->getService());
        $this->assertSame($rate, $shipmentRate->getRate());
        $this->assertSame(907, $shipmentRate->getRate()->getAmount());
        $this->assertSame(986, $shipmentRate->getListRate()->getAmount());
        $this->assertSame(1196, $shipmentRate->getRetailRate()->getAmount());
        $this->assertSame($deliveryDate->getTimestamp(), $shipmentRate->getDeliveryDate()->getTimestamp());
        $this->assertSame(5, $shipmentRate->getDeliveryDays());
        $this->assertSame(true, $shipmentRate->isDeliveryDateGuaranteed());
        $this->assertSame(5, $shipmentRate->getEstDeliveryDays());
        $this->assertTrue($shipmentRate->getDeliveryMethod()->isStandard());
    }
}
