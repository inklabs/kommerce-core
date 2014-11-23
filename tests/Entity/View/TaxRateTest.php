<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class TaxRateTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->taxRate = new Entity\TaxRate;
        $this->taxRate->setState(null);
        $this->taxRate->setZip5(92606);
        $this->taxRate->setZip5From(null);
        $this->taxRate->setZip5To(null);
        $this->taxRate->setRate(8.0);
        $this->taxRate->setApplyToShipping(false);
        $this->taxRate->setCreated(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->taxRate->setUpdated(null);

        $this->viewTaxRate = TaxRate::factory($this->taxRate);
    }

    public function testWithAllData()
    {
        $this->assertEquals(92606, $this->viewTaxRate->zip5);
    }
}
