<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class TaxRateTest extends EntityTestCase
{
    public function testCreate()
    {
        $taxRate = new TaxRate;
        $taxRate->setState(null);
        $taxRate->setZip5(null);
        $taxRate->setZip5From(null);
        $taxRate->setZip5To(null);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(false);

        $this->assertEntityValid($taxRate);
        $this->assertSame(null, $taxRate->getState());
        $this->assertSame(null, $taxRate->getZip5());
        $this->assertSame(null, $taxRate->getZip5From());
        $this->assertSame(null, $taxRate->getZip5To());
        $this->assertSame(8.0, $taxRate->getRate());
        $this->assertSame(false, $taxRate->getApplyToShipping());

        $taxRate->setZip5('92606');
        $this->assertSame('92606', $taxRate->getZip5());
    }

    public function testGetTax()
    {
        $taxRate = new TaxRate;
        $taxRate->setRate(10.0);
        $taxRate->setApplyToShipping(false);
        $this->assertSame(100, $taxRate->getTax(1000, 500));

        $taxRate->setApplyToShipping(true);
        $this->assertSame(150, $taxRate->getTax(1000, 500));
    }
}
