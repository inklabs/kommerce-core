<?php
namespace inklabs\kommerce\Entity;

class OrderItemTextOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $textOption = new TextOption;
        $textOption->setType(TextOption::TYPE_TEXTAREA);
        $textOption->setName('Custom Message');
        $textOption->setDescription('Custom engraved message');

        $orderItemTextOptionValue = new OrderItemTextOptionValue;
        $orderItemTextOptionValue->setTextOption($textOption);
        $orderItemTextOptionValue->setTextOptionValue('Happy Birthday');
        $orderItemTextOptionValue->setOrderItem(new OrderItem);

        $this->assertSame('Happy Birthday', $orderItemTextOptionValue->getTextOptionValue());
        $this->assertTrue($orderItemTextOptionValue->getTextOption() instanceof TextOption);
        $this->assertTrue($orderItemTextOptionValue->getOrderItem() instanceof OrderItem);
    }
}
