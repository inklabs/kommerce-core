<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\CartTotal;

class CartTotalTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $cart_total = new CartTotal;
        $cart_total->orig_subtotal = 1300;
        $cart_total->subtotal = 1300;
        $cart_total->shipping = 0;
        $cart_total->discount = 0;
        $cart_total->tax = 0;
        $cart_total->total = 1300;
        $cart_total->savings = 0;

        $this->assertEquals(1300, $cart_total->total);
    }
}
