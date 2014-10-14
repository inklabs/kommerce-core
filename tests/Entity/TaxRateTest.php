<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\TaxRate;

class TaxRateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->taxRate = new TaxRate;
        $this->taxRate->setZip5(92606);
        $this->taxRate->setRate(8.0);
        $this->taxRate->setApplyToShipping(false);
    }

    public function testGetTax()
    {
        $this->taxRate->setApplyToShipping(false);
        $this->assertEquals(80, $this->taxRate->getTax(1000, 500));

        $this->taxRate->setApplyToShipping(true);
        $this->assertEquals(120, $this->taxRate->getTax(1000, 500));
    }
}
