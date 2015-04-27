<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service;

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

        $product = new Product;
        $product->setSku('BS');
        $product->setName('Base Shirt');
        $product->setShippingWeight(16);

        $orderItem = new OrderItem;
        $orderItem->setProduct($product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice($product->getPrice(new Service\Pricing));
        $orderItem->addOrderItemTextOptionValue($orderItemTextOptionValue);

        $this->assertSame('Happy Birthday', $orderItemTextOptionValue->getTextOptionValue());
        $this->assertTrue($orderItemTextOptionValue->getTextOption() instanceof TextOption);
        $this->assertTrue($orderItemTextOptionValue->getOrderItem() instanceof OrderItem);
        $this->assertTrue($orderItemTextOptionValue->getView() instanceof View\OrderItemTextOptionValue);
    }
}
