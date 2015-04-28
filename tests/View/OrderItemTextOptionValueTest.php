<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OrderItemTextOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $orderItemTextOptionValue = new Entity\OrderItemTextOptionValue('Happy Birthday');
        $orderItemTextOptionValue->setTextOption(new Entity\TextOption);
        $orderItemTextOptionValue->setOrderItem(new Entity\OrderItem);

        $viewOrderItemTextOptionValue = $orderItemTextOptionValue->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($viewOrderItemTextOptionValue instanceof OrderItemTextOptionValue);
        $this->assertTrue($viewOrderItemTextOptionValue->textOption instanceof TextOption);
    }
}
