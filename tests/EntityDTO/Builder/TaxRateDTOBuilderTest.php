<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class TaxRateDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $taxRate = $this->dummyData->getTaxRate();

        $taxRateDTO = $taxRate->getDTOBuilder()
            ->build();

        $this->assertTrue($taxRateDTO instanceof TaxRateDTO);
    }
}
