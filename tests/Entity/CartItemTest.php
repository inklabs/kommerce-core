<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;
        $this->product->setName('Test Product');

        $this->cartItem = new CartItem($this->product, 1);
        $this->cartItem->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetProduct()
    {
        $this->assertEquals($this->product, $this->cartItem->getProduct());
    }
}
