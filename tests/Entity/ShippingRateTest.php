<?php
namespace inklabs\kommerce\Entity;

class ShippingRateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $rate = new ShippingRate;

        $this->assertSame(null, $rate->code);
        $this->assertSame(null, $rate->name);
        $this->assertSame(null, $rate->cost);
        $this->assertSame(null, $rate->deliveryTs);
        $this->assertSame(null, $rate->transitTime);
        $this->assertSame(null, $rate->weightInPounds);
        $this->assertSame(null, $rate->shipMethod);
        $this->assertSame(null, $rate->zip5);
        $this->assertSame(null, $rate->state);
        $this->assertSame(null, $rate->isResidential);
    }
}
