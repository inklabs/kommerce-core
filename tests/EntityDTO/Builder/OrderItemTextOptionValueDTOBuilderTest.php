<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OrderItemTextOptionValueDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $orderItemTextOptionValue = $this->dummyData->getOrderItemTextOptionValue();

        $orderItemTextOptionValueDTO = $orderItemTextOptionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemTextOptionValueDTO instanceof OrderItemTextOptionValueDTO);
        $this->assertTrue($orderItemTextOptionValueDTO->textOption instanceof TextOptionDTO);
    }
}
