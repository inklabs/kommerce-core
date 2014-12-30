<?php
namespace inklabs\kommerce;

class RateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $rate = new Entity\Shipping\Rate;

        $this->assertSame(null, $rate->code);
        $this->assertSame(null, $rate->name);
        $this->assertSame(null, $rate->cost);
    }
}
