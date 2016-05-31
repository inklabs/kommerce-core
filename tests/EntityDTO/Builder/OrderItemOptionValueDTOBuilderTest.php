<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class OrderItemOptionValueDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $orderItemOptionValue = $this->dummyData->getOrderItemOptionValue();

        $orderItemOptionValueDTO = $this->getDTOBuilderFactory()
            ->getOrderItemOptionValueDTOBuilder($orderItemOptionValue)
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemOptionValueDTO instanceof OrderItemOptionValueDTO);
        $this->assertTrue($orderItemOptionValueDTO->optionValue instanceof OptionValueDTO);
        $this->assertTrue($orderItemOptionValueDTO->optionValue->option instanceof OptionDTO);
    }
}
