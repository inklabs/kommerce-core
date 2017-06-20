<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OrderItemOptionValueTest extends EntityTestCase
{
    public function testCreate()
    {
        $option = $this->dummyData->getOption();
        $option->setName('Shirt Size');

        $optionValue = $this->dummyData->getOptionValue($option);
        $optionValue->setSku('MD');
        $optionValue->setName('Medium Shirt');

        $orderItem = $this->dummyData->getOrderItem();

        $orderItemOptionValue = new OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem($orderItem);

        $this->assertSame('MD', $orderItemOptionValue->getSku());
        $this->assertSame('Shirt Size', $orderItemOptionValue->getOptionName());
        $this->assertSame('Medium Shirt', $orderItemOptionValue->getOptionValueName());
        $this->assertSame($optionValue, $orderItemOptionValue->getOptionValue());
        $this->assertSame($orderItem, $orderItemOptionValue->getOrderItem());
    }
}
