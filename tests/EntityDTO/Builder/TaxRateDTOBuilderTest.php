<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class TaxRateDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $taxRate = $this->dummyData->getTaxRate();

        $taxRateDTO = $this->getDTOBuilderFactory()
            ->getTaxRateDTOBuilder($taxRate)
            ->build();

        $this->assertTrue($taxRateDTO instanceof TaxRateDTO);
    }
}
