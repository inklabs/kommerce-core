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

        $orderItemOptionValue = new OrderItemOptionValue($option);
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem($orderItem);

        $this->assertSame('Test Option', $orderItemOptionValue->getName());
        $this->assertSame('TST', $orderItemOptionValue->getSku());
        $this->assertSame('Test Product', $orderItemOptionValue->getValue());
        $this->assertTrue($orderItemOptionValue->getOptionValue() instanceof OptionValue);
        $this->assertTrue($orderItemOptionValue->getOrderItem() instanceof OrderItem);
        $this->assertTrue($orderItemOptionValue->getView() instanceof View\OrderItemOptionValue);
    }

    public function testCreateOrderItemOptionValueWithCustomValue()
    {
        $product = new Product;
        $product->setSku('TST');
        $product->setname('Test Product');

        $orderItem = new OrderItem;
        $orderItem->setProduct(new Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice(new Price);

        $option = new Option;
        $option->setName('Custom Engraving');

        $orderItemOptionValue = new OrderItemOptionValue($option);
        $orderItemOptionValue->setSku('HPB');
        $orderItemOptionValue->setValue('Happy Birthday');
        $orderItemOptionValue->setOrderItem($orderItem);

        $this->assertSame('Custom Engraving', $orderItemOptionValue->getName());
        $this->assertSame('HPB', $orderItemOptionValue->getSku());
        $this->assertSame('Happy Birthday', $orderItemOptionValue->getValue());
        $this->assertSame(null, $orderItemOptionValue->getOptionValue());
        $this->assertTrue($orderItemOptionValue->getOrderItem() instanceof OrderItem);
        $this->assertTrue($orderItemOptionValue->getView() instanceof View\OrderItemOptionValue);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage OptionValue already exists
     */
    public function testCreateOrderItemOptionValueThrowsExceptionWithCustom()
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

        $orderItemOptionValue = new OrderItemOptionValue($option);
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItemOptionValue->setValue('Happy Birthday');
    }
}
