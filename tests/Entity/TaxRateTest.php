<?php
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\CartTotal;

class TaxRateTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers TaxRate::get_tax
	 */
	public function test_get_tax()
	{
		$tax_rate = new TaxRate;
		$tax_rate->zip5 = 92606;
		$tax_rate->rate = 8.0;

		$tax_rate->apply_to_shipping = FALSE;
		$this->assertEquals(80, $tax_rate->get_tax(1000, 500));

		$tax_rate->apply_to_shipping = TRUE;
		$this->assertEquals(120, $tax_rate->get_tax(1000, 500));
	}
}
