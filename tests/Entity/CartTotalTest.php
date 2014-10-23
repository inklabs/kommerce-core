<?php
namespace inklabs\kommerce\Entity;

class CartTotalTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->cartTotal = new CartTotal;
        $this->cartTotal->origSubtotal = 1300;
        $this->cartTotal->subtotal = 1300;
        $this->cartTotal->shipping = 0;
        $this->cartTotal->discount = 0;
        $this->cartTotal->tax = 0;
        $this->cartTotal->total = 1300;
        $this->cartTotal->savings = 0;
    }

    public function testValues()
    {
        $this->assertEquals(1300, $this->cartTotal->total);
    }
}
