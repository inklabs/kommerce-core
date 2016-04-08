<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OrderItemTextOptionValueTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $orderItemTextOptionValue = new OrderItemTextOptionValue;

        $this->assertSame(null, $orderItemTextOptionValue->getTextOptionValue());
        $this->assertSame(null, $orderItemTextOptionValue->getTextOption());
        $this->assertSame(null, $orderItemTextOptionValue->getOrderItem());
    }

    public function testCreate()
    {
        $textOption = $this->dummyData->getTextOption();
        $orderItem = new OrderItem;

        $orderItemTextOptionValue = new OrderItemTextOptionValue;
        $orderItemTextOptionValue->setTextOptionValue('Happy Birthday');
        $orderItemTextOptionValue->setTextOption($textOption);
        $orderItemTextOptionValue->setOrderItem($orderItem);

        $this->assertSame('Happy Birthday', $orderItemTextOptionValue->getTextOptionValue());
        $this->assertSame($textOption, $orderItemTextOptionValue->getTextOption());
        $this->assertSame($orderItem, $orderItemTextOptionValue->getOrderItem());
    }
}
