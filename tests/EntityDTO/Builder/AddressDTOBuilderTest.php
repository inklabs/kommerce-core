<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\EntityDTO\AddressDTO;
use inklabs\kommerce\EntityDTO\PointDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class AddressDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $address = $this->dummyData->getAddress();

        $addressDTO = $this->getDTOBuilderFactory()
            ->getAddressDTOBuilder($address)
            ->build();

        $this->assertTrue($addressDTO instanceof AddressDTO);
        $this->assertTrue($addressDTO->point instanceof PointDTO);
    }
}
