<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class OrderAddressDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $orderAddress = $this->dummyData->getOrderAddress();

        $orderAddressDTO = $this->getDTOBuilderFactory()
            ->getOrderAddressDTOBuilder($orderAddress)
            ->build();

        $this->assertTrue($orderAddressDTO instanceof OrderAddressDTO);
    }
}
