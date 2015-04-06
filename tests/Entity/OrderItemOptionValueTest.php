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

        $optionValue = new OptionValue($option);
        $optionValue->setProduct($product);

        $orderItem = new OrderItem;
        $orderItem->setProduct(new Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice(new Price);

        $orderItemOptionValue = new OrderItemOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem($orderItem);

        $this->assertSame('Test Option', $orderItemOptionValue->getOptionName());
        $this->assertSame('TST', $orderItemOptionValue->getSku());
        $this->assertSame('Test Product', $orderItemOptionValue->getOptionValueName());
        $this->assertTrue($orderItemOptionValue->getOptionValue() instanceof OptionValue);
        $this->assertTrue($orderItemOptionValue->getOrderItem() instanceof OrderItem);
        $this->assertTrue($orderItemOptionValue->getView() instanceof View\OrderItemOptionValue);
    }
}
