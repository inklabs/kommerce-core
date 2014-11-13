<?php
namespace inklabs\kommerce\Entity;

class PriceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->price = new Price;
        $this->price->origUnitPrice = 2500;
        $this->price->origQuantityPrice = 2500;
        $this->price->unitPrice = 1750;
        $this->price->quantityPrice = 1750;
    }

    public function test()
    {
    }
}
