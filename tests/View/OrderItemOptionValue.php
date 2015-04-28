<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OrderItemOptionValueTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $optionValue = new Entity\OptionValue;
        $optionValue->setOption(new Entity\Option);

        $orderItemOptionValue = new Entity\OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem(new Entity\OrderItem);

        $viewOrderItemOptionValue = $orderItemOptionValue->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($viewOrderItemOptionValue instanceof OrderItemOptionValue);
    }
}
