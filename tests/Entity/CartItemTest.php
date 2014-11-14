<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
        $this->product->setName('Test Product');
        $this->product->setUnitPrice(500);

        $this->cartItem = new CartItem($this->product, 1);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->cartItem->getId());
        $this->assertEquals($this->product, $this->cartItem->getProduct());
    }

    public function testGetItemPrice()
    {
        $pricing = new Service\Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
        $price = $this->cartItem->getPrice($pricing);

        $expectedPrice = new Price;
        $expectedPrice->origUnitPrice = 500;
        $expectedPrice->unitPrice = 500;
        $expectedPrice->origQuantityPrice = 500;
        $expectedPrice->quantityPrice = 500;
        $this->assertEquals($expectedPrice, $price);
    }
}
