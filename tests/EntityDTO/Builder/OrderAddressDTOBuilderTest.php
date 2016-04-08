<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\OrderAddress;

class OrderAddressDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $orderAddress = new OrderAddress;

        $orderAddressDTO = $orderAddress->getDTOBuilder()
            ->build();

        $this->assertTrue($orderAddressDTO instanceof OrderAddressDTO);
    }
}
