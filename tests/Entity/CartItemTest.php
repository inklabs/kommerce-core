<?php
namespace inklabs\kommerce\Entity;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
        $this->product->setName('Test Product');

        $this->cartItem = new CartItem;
        $this->cartItem->setProduct($this->product);
        $this->cartItem->setQuantity(1);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->cartItem->getId());
        $this->assertEquals($this->product, $this->cartItem->getProduct());
    }
}
