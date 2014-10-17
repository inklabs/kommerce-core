<?php
namespace inklabs\kommerce\Entity;

class TaxRateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->taxRate = new TaxRate;
        $this->taxRate->setState(null);
        $this->taxRate->setZip5(92606);
        $this->taxRate->setZip5From(null);
        $this->taxRate->setZip5To(null);
        $this->taxRate->setRate(8.0);
        $this->taxRate->setApplyToShipping(false);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->taxRate->getId());
        $this->assertEquals(null, $this->taxRate->getState());
        $this->assertEquals(92606, $this->taxRate->getZip5());
        $this->assertEquals(null, $this->taxRate->getZip5From());
        $this->assertEquals(null, $this->taxRate->getZip5To());
        $this->assertEquals(8.0, $this->taxRate->getRate());
        $this->assertEquals(false, $this->taxRate->getApplyToShipping());
    }

    public function testGetTax()
    {
        $this->taxRate->setApplyToShipping(false);
        $this->assertEquals(80, $this->taxRate->getTax(1000, 500));

        $this->taxRate->setApplyToShipping(true);
        $this->assertEquals(120, $this->taxRate->getTax(1000, 500));
    }
}
