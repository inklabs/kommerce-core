<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class ParcelDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $price = $this->dummyData->getParcel();

        $priceDTO = $this->getDTOBuilderFactory()
            ->getParcelDTOBuilder($price)
            ->build();

        $this->assertTrue($priceDTO instanceof ParcelDTO);
    }
}
