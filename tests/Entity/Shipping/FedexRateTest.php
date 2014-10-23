<?php
namespace inklabs\kommerce;

class FedexRateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->rate = new Entity\Shipping\FedexRate;
    }

    public function testGetProperties()
    {
        $this->assertEquals(null, $this->rate->code);
        $this->assertEquals(null, $this->rate->name);
        $this->assertEquals(null, $this->rate->cost);
        $this->assertEquals(null, $this->rate->deliveryTs);
        $this->assertEquals(null, $this->rate->transitTime);
    }
}
