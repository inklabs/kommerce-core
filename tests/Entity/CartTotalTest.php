<?php
namespace inklabs\kommerce\Entity;

class CartTotalTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->cart_total = new CartTotal;
        $this->cart_total->orig_subtotal = 1300;
        $this->cart_total->subtotal = 1300;
        $this->cart_total->shipping = 0;
        $this->cart_total->discount = 0;
        $this->cart_total->tax = 0;
        $this->cart_total->total = 1300;
        $this->cart_total->savings = 0;
    }

    public function testValues()
    {
        $this->assertEquals(1300, $this->cart_total->total);
    }
}
