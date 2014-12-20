<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCartItem()
    {
        $product = new Product;
        $product->setUnitPrice(500);
        $product->setShippingWeight(10);

        $cartItem = new CartItem($product, 2);
        $cartItem->setId(1);

        $pricing = new Service\Pricing;

        $this->assertEquals(1, $cartItem->getId());
        $this->assertEquals(2, $cartItem->getQuantity());
        $this->assertTrue($cartItem->getProduct() instanceof Product);
        $this->assertTrue($cartItem->getPrice($pricing) instanceof Price);
        $this->assertEquals(20, $cartItem->getShippingWeight());
    }

    public function testSetProductAndQuantity()
    {
        $cartItem = new CartItem(new Product, 2);
        $cartItem->setProduct(new Product);
        $cartItem->setQuantity(3);
        $this->assertTrue($cartItem->getProduct() instanceof Product);
        $this->assertEquals(3, $cartItem->getQuantity());
    }
}
