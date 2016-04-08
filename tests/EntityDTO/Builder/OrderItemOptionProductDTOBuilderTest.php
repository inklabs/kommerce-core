<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OrderItemOptionProductDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $orderItemOptionProduct = $this->dummyData->getOrderItemOptionProduct();

        $orderItemOptionProductDTO = $orderItemOptionProduct->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($orderItemOptionProductDTO instanceof OrderItemOptionProductDTO);
        $this->assertTrue($orderItemOptionProductDTO->optionProduct instanceof OptionProductDTO);
        $this->assertTrue($orderItemOptionProductDTO->optionProduct->option instanceof OptionDTO);
    }
}
