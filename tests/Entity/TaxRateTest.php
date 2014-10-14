<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\TaxRate;

class TaxRateTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTax()
    {
        $tax_rate = new TaxRate;
        $tax_rate->zip5 = 92606;
        $tax_rate->rate = 8.0;

        $tax_rate->apply_to_shipping = false;
        $this->assertEquals(80, $tax_rate->getTax(1000, 500));

        $tax_rate->apply_to_shipping = true;
        $this->assertEquals(120, $tax_rate->getTax(1000, 500));
    }
}
