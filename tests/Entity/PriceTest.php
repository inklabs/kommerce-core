<?php
use inklabs\kommerce\Entity\Price;

class PriceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Price::__construct
     */
    public function test_construct()
    {
        $price = new Price;
        $price->unit_price = 2400;
        $price->orig_unit_price = 2400;
        $price->quantity_price = 2400;
        $price->orig_quantity_price = 2400;

        $this->assertEquals(2400, $price->unit_price);
    }
}
