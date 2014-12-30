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

        $this->assertSame(1, $cartItem->getId());
        $this->assertSame(2, $cartItem->getQuantity());
        $this->assertTrue($cartItem->getProduct() instanceof Product);
        $this->assertTrue($cartItem->getPrice($pricing) instanceof Price);
        $this->assertSame(20, $cartItem->getShippingWeight());
        $this->assertTrue($cartItem->getView() instanceof View\CartItem);
    }

    public function testSetProductAndQuantity()
    {
        $cartItem = new CartItem(new Product, 2);
        $cartItem->setProduct(new Product);
        $cartItem->setQuantity(3);
        $this->assertTrue($cartItem->getProduct() instanceof Product);
        $this->assertSame(3, $cartItem->getQuantity());
    }
}
