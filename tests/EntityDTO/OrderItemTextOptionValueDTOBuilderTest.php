<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\TextOption;

class OrderItemTextOptionValueDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $orderItemTextOptionValue = new OrderItemTextOptionValue('Happy Birthday');
        $orderItemTextOptionValue->setTextOption(new TextOption);
        $orderItemTextOptionValue->setOrderItem(new OrderItem);

        $orderItemTextOptionValueDTO = $orderItemTextOptionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemTextOptionValueDTO instanceof OrderItemTextOptionValueDTO);
        $this->assertTrue($orderItemTextOptionValueDTO->textOption instanceof TextOptionDTO);
    }
}
