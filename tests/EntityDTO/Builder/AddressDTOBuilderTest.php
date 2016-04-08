<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Address;
use inklabs\kommerce\Entity\Point;

class AddressDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $address = new Address;
        $address->setPoint(new Point);

        $addressDTO = $address->getDTOBuilder()
            ->build();

        $this->assertTrue($addressDTO instanceof AddressDTO);
        $this->assertTrue($addressDTO->point instanceof PointDTO);
    }
}
