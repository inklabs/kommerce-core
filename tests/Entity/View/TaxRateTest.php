<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class TaxRateTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityTaxRate = new Entity\TaxRate;
        $taxRate = $entityTaxRate->getView();

        $this->assertTrue($taxRate instanceof TaxRate);
    }
}
