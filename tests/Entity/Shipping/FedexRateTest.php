<?php
namespace inklabs\kommerce;

class FedexRateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $rate = new Entity\Shipping\FedexRate;

        $this->assertSame(null, $rate->deliveryTs);
        $this->assertSame(null, $rate->transitTime);
    }
}
