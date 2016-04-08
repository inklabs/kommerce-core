<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class AddressDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $address = $this->dummyData->getAddress();

        $addressDTO = $address->getDTOBuilder()
            ->build();

        $this->assertTrue($addressDTO instanceof AddressDTO);
        $this->assertTrue($addressDTO->point instanceof PointDTO);
    }
}
