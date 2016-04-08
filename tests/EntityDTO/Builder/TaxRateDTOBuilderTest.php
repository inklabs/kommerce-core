<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\TaxRate;

class TaxRateDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $taxRate = new TaxRate;

        $taxRateDTO = $taxRate->getDTOBuilder()
            ->build();

        $this->assertTrue($taxRateDTO instanceof TaxRateDTO);
    }
}
