<?php
namespace inklabs\kommerce;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;
        $this->product->setName('Test Product');

        $this->cartItem = new Entity\CartItem;
        $this->cartItem->setProduct($this->product);
        $this->cartItem->setQuantity(1);
        $this->cartItem->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->cartItem->getId());
        $this->assertEquals($this->product, $this->cartItem->getProduct());
    }
}
