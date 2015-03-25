<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class CartItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateCartItem()
    {
        $product = new Product;
        $product->setSku('PRD1');
        $product->setUnitPrice(100);
        $product->setShippingWeight(10);

        $product2 = new Product;
        $product2->setSku('OPT2');
        $product2->setUnitPrice(20);
        $product2->setShippingWeight(2);

        $optionProduct = new CartItemOptionProduct(new Option, $product2);

        $cartItem = new CartItem($product, 2);
        $cartItem->setId(1);
        $cartItem->addOptionProduct($optionProduct);

        $pricing = new Service\Pricing;

        $this->assertSame(1, $cartItem->getId());
        $this->assertSame(2, $cartItem->getQuantity());
        $this->assertSame('PRD1-OPT2', $cartItem->getFullSku());
        $this->assertTrue($cartItem->getProduct() instanceof Product);
        $this->assertTrue($cartItem->getOptionProducts()[0] instanceof CartItemOptionProduct);
        $this->assertTrue($cartItem->getPrice($pricing) instanceof Price);
        $this->assertSame(240, $cartItem->getPrice($pricing)->quantityPrice);
        $this->assertSame(24, $cartItem->getShippingWeight());
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

    public function testGetOrderItem()
    {
        $cartItem = new CartItem(new Product, 1);
        $cartItem->addOptionProduct(new CartItemOptionProduct(new Option, new Product));

        $this->assertTrue($cartItem->getOrderItem(new Service\Pricing) instanceof OrderItem);
    }
}
