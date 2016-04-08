<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class TaxRateDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $taxRate = $this->dummyData->getTaxRate();

        $taxRateDTO = $taxRate->getDTOBuilder()
            ->build();

        $this->assertTrue($taxRateDTO instanceof TaxRateDTO);
    }
}
