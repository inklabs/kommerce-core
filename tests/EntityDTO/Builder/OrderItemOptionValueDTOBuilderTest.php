<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionValue;

class OrderItemOptionValueDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $optionValue = new OptionValue;
        $optionValue->setOption(new Option);

        $orderItemOptionValue = new OrderItemOptionValue;
        $orderItemOptionValue->setOptionValue($optionValue);
        $orderItemOptionValue->setOrderItem(new OrderItem);

        $orderItemOptionValueDTO = $orderItemOptionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemOptionValueDTO instanceof OrderItemOptionValueDTO);
        $this->assertTrue($orderItemOptionValueDTO->optionValue instanceof OptionValueDTO);
        $this->assertTrue($orderItemOptionValueDTO->optionValue->option instanceof OptionDTO);
    }
}
