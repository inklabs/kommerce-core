<?php
namespace inklabs\kommerce;

class RateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $rate = new Entity\Shipping\Rate;

        $this->assertEquals(null, $rate->code);
        $this->assertEquals(null, $rate->name);
        $this->assertEquals(null, $rate->cost);
    }
}
