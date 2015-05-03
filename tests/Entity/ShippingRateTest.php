<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;

class ShippingRateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $rate = new ShippingRate;
        $rate->setCode('4');
        $rate->setName('Parcel Post');
        $rate->setCost(1000);
        $rate->setDeliveryTs(1430611854);
        $rate->setTransitTime('2 days');
        $rate->setWeightInPounds(3);
        $rate->setShipMethod('usps');
        $rate->setZip5('90403');
        $rate->setState('CA');
        $rate->setIsResidential(true);

        $this->assertSame('4', $rate->getCode());
        $this->assertSame('Parcel Post', $rate->getName());
        $this->assertSame(1000, $rate->getCost());
        $this->assertSame(1430611854, $rate->getDeliveryTs());
        $this->assertSame('2 days', $rate->getTransitTime());
        $this->assertSame(3, $rate->getWeightInPounds());
        $this->assertSame('usps', $rate->getShipMethod());
        $this->assertSame('90403', $rate->getZip5());
        $this->assertSame('CA', $rate->getState());
        $this->assertSame(true, $rate->isResidential());
        $this->assertTrue($rate->getView() instanceof View\ShippingRate);
    }
}
