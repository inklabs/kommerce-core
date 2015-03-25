<?php
namespace inklabs\kommerce\Entity;

class OrderItemOptionProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateOrderItemOptionProduct()
    {
        $option = new Option;
        $option->setName('Test Option');

        $product = new Product;
        $product->setSku('TST');
        $product->setname('Test Product');

        $cartItemOptionProduct = new OrderItemOptionProduct($option, $product);
        $cartItemOptionProduct->setId(1);
        $cartItemOptionProduct->setOrderItem(new OrderItem(new Product, 1, new Price));

        $this->assertSame(1, $cartItemOptionProduct->getId());
        $this->assertSame('Test Option', $cartItemOptionProduct->getOptionName());
        $this->assertSame('TST', $cartItemOptionProduct->getProductSku());
        $this->assertSame('Test Product', $cartItemOptionProduct->getProductName());
        $this->assertTrue($cartItemOptionProduct->getOption() instanceof Option);
        $this->assertTrue($cartItemOptionProduct->getProduct() instanceof Product);
        $this->assertTrue($cartItemOptionProduct->getOrderItem() instanceof OrderItem);
        $this->assertTrue($cartItemOptionProduct->getView() instanceof View\OrderItemOptionProduct);
    }
}
