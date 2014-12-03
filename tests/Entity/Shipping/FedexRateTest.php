<?php
namespace inklabs\kommerce;

class FedexRateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $rate = new Entity\Shipping\FedexRate;

        $this->assertEquals(null, $rate->deliveryTs);
        $this->assertEquals(null, $rate->transitTime);
    }
}
