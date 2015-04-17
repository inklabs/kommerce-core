<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;

class OrderItemOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateOrderItemOptionValue()
    {
        $product = new Product;
        $product->setSku('TST');
        $product->setname('Test Product');

        $optionValue = $this->getMockedOptionValue();

        $orderItem = new OrderItem;
        $orderItem->setProduct(new Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice(new Price);

        $orderItemOptionValue = new OrderItemOptionValue($optionValue);
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem($orderItem);

        $this->assertSame('OPT2', $orderItemOptionValue->getSku());
        $this->assertSame('Test Option Type Name', $orderItemOptionValue->getOptionTypeName());
        $this->assertSame('Test Option Value Name', $orderItemOptionValue->getOptionValueName());
        $this->assertTrue($orderItemOptionValue->getOptionValue() instanceof OptionValue\OptionValueInterface);
        $this->assertTrue($orderItemOptionValue->getOrderItem() instanceof OrderItem);
        $this->assertTrue($orderItemOptionValue->getView() instanceof View\OrderItemOptionValue);
    }

    /**
     * @return OptionValue\OptionValueInterface
     */
    private function getMockedOptionValue()
    {
        $price = new Price;
        $price->unitPrice = 20;
        $price->quantityPrice = 40;

        $optionType = \Mockery::mock('inklabs\kommerce\Entity\OptionType\OptionTypeInterface');
        $optionType->shouldReceive('getName')->andReturn('Test Option Type Name');

        $viewOptionValue = \Mockery::mock('inklabs\kommerce\View\OptionValue\OptionValueInterface');
        $viewOptionValue->shouldReceive('export')->andReturn($viewOptionValue);

        $optionValue = \Mockery::mock('inklabs\kommerce\Entity\OptionValue\OptionValueInterface');
        $optionValue->shouldReceive('getSku')->andReturn('OPT2');
        $optionValue->shouldReceive('getName')->andReturn('Test Option Value Name');
        $optionValue->shouldReceive('getPrice')->andReturn($price);
        $optionValue->shouldReceive('getShippingWeight')->andReturn(2);
        $optionValue->shouldReceive('getOptionType')->andReturn($optionType);
        $optionValue->shouldReceive('getView')->andReturn($viewOptionValue);

        return $optionValue;
    }
}
