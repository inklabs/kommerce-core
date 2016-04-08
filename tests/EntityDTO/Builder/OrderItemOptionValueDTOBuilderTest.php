<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OrderItemOptionValueDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $orderItemOptionValue = $this->dummyData->getOrderItemOptionValue();

        $orderItemOptionValueDTO = $orderItemOptionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemOptionValueDTO instanceof OrderItemOptionValueDTO);
        $this->assertTrue($orderItemOptionValueDTO->optionValue instanceof OptionValueDTO);
        $this->assertTrue($orderItemOptionValueDTO->optionValue->option instanceof OptionDTO);
    }
}
