<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\ShipmentRateDTOBuilder;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class ShipmentRateTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $shipmentRate = new ShipmentRate(new Money(907, 'USD'));

        $this->assertSame(null, $shipmentRate->getDeliveryDate());

        $shipmentRate->setExternalId('rate_xxxxxx');
        $shipmentRate->setShipmentExternalId('shp_xxxxxx');
        $shipmentRate->setCarrier('UPS');
        $shipmentRate->setService('Ground');
        $shipmentRate->setListRate(new Money(986, 'USD'));
        $shipmentRate->setRetailRate(new Money(1196, 'USD'));
        $shipmentRate->setDeliveryDate(new DateTime);
        $shipmentRate->setIsDeliveryDateGuaranteed(true);
        $shipmentRate->setDeliveryDays(5);
        $shipmentRate->setEstDeliveryDays(5);

        $this->assertEntityValid($shipmentRate);
        $this->assertSame('rate_xxxxxx', $shipmentRate->getExternalId());
        $this->assertSame('shp_xxxxxx', $shipmentRate->getShipmentExternalId());
        $this->assertSame('UPS', $shipmentRate->getCarrier());
        $this->assertSame('Ground', $shipmentRate->getService());
        $this->assertSame(907, $shipmentRate->getRate()->getAmount());
        $this->assertSame(986, $shipmentRate->getListRate()->getAmount());
        $this->assertSame(1196, $shipmentRate->getRetailRate()->getAmount());
        $this->assertTrue($shipmentRate->getDeliveryDate() instanceof DateTime);
        $this->assertSame(5, $shipmentRate->getDeliveryDays());
        $this->assertSame(true, $shipmentRate->isDeliveryDateGuaranteed());
        $this->assertSame(5, $shipmentRate->getEstDeliveryDays());
        $this->assertTrue($shipmentRate->getDTOBuilder() instanceof ShipmentRateDTOBuilder);
    }

    public function testDeliveryMethodStandard()
    {
        $shipmentRate = new ShipmentRate(new Money(907, 'USD'));
        $shipmentRate->setDeliveryDays(3);
        $this->assertSame(ShipmentRate::DELIVERY_METHOD_STANDARD, $shipmentRate->getDeliveryMethod());
        $this->assertSame('Standard', $shipmentRate->getDeliveryMethodText());
    }

    public function testDeliveryMethodOneDay()
    {
        $shipmentRate = new ShipmentRate(new Money(907, 'USD'));
        $shipmentRate->setDeliveryDays(1);
        $this->assertSame(ShipmentRate::DELIVERY_METHOD_ONE_DAY, $shipmentRate->getDeliveryMethod());
        $this->assertSame('One-Day', $shipmentRate->getDeliveryMethodText());
    }

    public function testDeliveryMethodTwoDay()
    {
        $shipmentRate = new ShipmentRate(new Money(907, 'USD'));
        $shipmentRate->setDeliveryDays(2);
        $this->assertSame(ShipmentRate::DELIVERY_METHOD_TWO_DAY, $shipmentRate->getDeliveryMethod());
        $this->assertSame('Two-Day', $shipmentRate->getDeliveryMethodText());
    }
}
