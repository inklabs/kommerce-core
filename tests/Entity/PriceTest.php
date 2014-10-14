<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Price;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->price = new Price;
        $this->price->unit_price = 2400;
        $this->price->orig_unit_price = 2400;
        $this->price->quantity_price = 2400;
        $this->price->orig_quantity_price = 2400;
    }

    public function testGetUnitPrice()
    {
        $this->assertEquals(2400, $this->price->unit_price);
    }
}
