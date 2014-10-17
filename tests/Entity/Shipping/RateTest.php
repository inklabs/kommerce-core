<?php
namespace inklabs\kommerce;

class RateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->rate = new Entity\Shipping\Rate;
    }

    public function testGetProperties()
    {
        $this->assertEquals(null, $this->rate->code);
        $this->assertEquals(null, $this->rate->name);
        $this->assertEquals(null, $this->rate->cost);
    }
}
