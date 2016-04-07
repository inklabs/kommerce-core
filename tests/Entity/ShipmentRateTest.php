<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\ShipmentRateDTOBuilder;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentRateTest extends DoctrineTestCase
{
    public function testCreateDefaults()
    {
        $rate = $this->dummyData->getMoney(907);

        $shipmentRate = new ShipmentRate($rate);

        $this->assertSame(null, $shipmentRate->getExternalId());
        $this->assertSame(null, $shipmentRate->getShipmentExternalId());
        $this->assertSame(null, $shipmentRate->getCarrier());
        $this->assertSame(null, $shipmentRate->getService());
        $this->assertSame($rate, $shipmentRate->getRate());
        $this->assertSame(null, $shipmentRate->getListRate());
        $this->assertSame(null, $shipmentRate->getRetailRate());
        $this->assertSame(null, $shipmentRate->getDeliveryDate());
        $this->assertSame(null, $shipmentRate->getDeliveryDays());
        $this->assertSame(false, $shipmentRate->isDeliveryDateGuaranteed());
        $this->assertSame(null, $shipmentRate->getEstDeliveryDays());
    }

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
        $this->assertEquals($deliveryDate, $shipmentRate->getDeliveryDate());
        $this->assertSame(5, $shipmentRate->getDeliveryDays());
        $this->assertSame(true, $shipmentRate->isDeliveryDateGuaranteed());
        $this->assertSame(5, $shipmentRate->getEstDeliveryDays());
        $this->assertTrue($shipmentRate->getDTOBuilder() instanceof ShipmentRateDTOBuilder);
    }

    public function testDeliveryMethodStandard()
    {
        $shipmentRate = new ShipmentRate($this->dummyData->getMoney(907));
        $shipmentRate->setDeliveryDays(3);
        $this->assertSame(ShipmentRate::DELIVERY_METHOD_STANDARD, $shipmentRate->getDeliveryMethod());
        $this->assertSame('Standard', $shipmentRate->getDeliveryMethodText());
    }

    public function testDeliveryMethodOneDay()
    {
        $shipmentRate = new ShipmentRate($this->dummyData->getMoney(907));
        $shipmentRate->setDeliveryDays(1);
        $this->assertSame(ShipmentRate::DELIVERY_METHOD_ONE_DAY, $shipmentRate->getDeliveryMethod());
        $this->assertSame('One-Day', $shipmentRate->getDeliveryMethodText());
    }

    public function testDeliveryMethodTwoDay()
    {
        $shipmentRate = new ShipmentRate($this->dummyData->getMoney(907));
        $shipmentRate->setDeliveryDays(2);
        $this->assertSame(ShipmentRate::DELIVERY_METHOD_TWO_DAY, $shipmentRate->getDeliveryMethod());
        $this->assertSame('Two-Day', $shipmentRate->getDeliveryMethodText());
    }

    public function testDeliveryMethodEmptyDefault()
    {
        $shipmentRate = new ShipmentRate($this->dummyData->getMoney(907));
        $this->assertSame('Standard', $shipmentRate->getDeliveryMethodText());
    }
}
