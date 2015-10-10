<?php
namespace inklabs\kommerce\Entity;

class OrderItemOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $option = new Option;
        $option->setType(Option::TYPE_SELECT);
        $option->setName('Shirt Size');
        $option->setDescription('Shirt Size Description');

        $optionValue = new OptionValue;
        $optionValue->setSortOrder(0);
        $optionValue->setSku('MD');
        $optionValue->setName('Medium Shirt');
        $optionValue->setShippingWeight(0);
        $optionValue->setUnitPrice(500);
        $optionValue->setOption($option);

        $orderItemOptionValue = new OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem(new OrderItem);

        $this->assertSame('MD', $orderItemOptionValue->getSku());
        $this->assertSame('Shirt Size', $orderItemOptionValue->getOptionName());
        $this->assertSame('Medium Shirt', $orderItemOptionValue->getOptionValueName());
        $this->assertTrue($orderItemOptionValue->getOptionValue() instanceof OptionValue);
        $this->assertTrue($orderItemOptionValue->getOrderItem() instanceof OrderItem);
    }
}
