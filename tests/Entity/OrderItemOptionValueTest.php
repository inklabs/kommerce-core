<?php
namespace inklabs\kommerce\Entity;

class OrderItemOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateOrderItemOptionValue()
    {
        $option = new Option;
        $option->setName('Test Option');

        $product = new Product;
        $product->setSku('TST');
        $product->setname('Test Product');

        $optionValue = new OptionValue;
        $optionValue->setOption($option);
        $optionValue->setProduct($product);

        $orderItemOptionValue = new OrderItemOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem(new OrderItem(new Product, 1, new Price));

        $this->assertSame('Test Option', $orderItemOptionValue->getOptionName());
        $this->assertSame('TST', $orderItemOptionValue->getSku());
        $this->assertSame('Test Product', $orderItemOptionValue->getName());
        $this->assertTrue($orderItemOptionValue->getOptionValue() instanceof OptionValue);
        $this->assertTrue($orderItemOptionValue->getOrderItem() instanceof OrderItem);
        $this->assertTrue($orderItemOptionValue->getView() instanceof View\OrderItemOptionValue);
    }
}
