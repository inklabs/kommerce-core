<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class OrderAddressDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $orderAddress = $this->dummyData->getOrderAddress();

        $orderAddressDTO = $orderAddress->getDTOBuilder()
            ->build();

        $this->assertTrue($orderAddressDTO instanceof OrderAddressDTO);
    }
}
