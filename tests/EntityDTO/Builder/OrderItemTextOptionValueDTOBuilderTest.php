<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class OrderItemTextOptionValueDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $orderItemTextOptionValue = $this->dummyData->getOrderItemTextOptionValue();

        $orderItemTextOptionValueDTO = $this->getDTOBuilderFactory()
            ->getOrderItemTextOptionValueDTOBuilder($orderItemTextOptionValue)
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemTextOptionValueDTO instanceof OrderItemTextOptionValueDTO);
        $this->assertTrue($orderItemTextOptionValueDTO->textOption instanceof TextOptionDTO);
    }
}
