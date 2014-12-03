<?php
namespace inklabs\kommerce\Entity;

class TaxRateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $taxRate = new TaxRate;
        $taxRate->setId(1);
        $taxRate->setState(null);
        $taxRate->setZip5('92606');
        $taxRate->setZip5From(null);
        $taxRate->setZip5To(null);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $this->assertEquals(1, $taxRate->getId());
        $this->assertEquals(null, $taxRate->getState());
        $this->assertEquals('92606', $taxRate->getZip5());
        $this->assertEquals(null, $taxRate->getZip5From());
        $this->assertEquals(null, $taxRate->getZip5To());
        $this->assertEquals(8.0, $taxRate->getRate());
        $this->assertEquals(false, $taxRate->getApplyToShipping());
    }

    public function testGetTax()
    {
        $taxRate = new TaxRate;
        $taxRate->setRate(10.0);
        $taxRate->setApplyToShipping(false);
        $this->assertEquals(100, $taxRate->getTax(1000, 500));

        $taxRate->setApplyToShipping(true);
        $this->assertEquals(150, $taxRate->getTax(1000, 500));
    }
}
