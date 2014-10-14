<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\Product;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Product;

        $this->cartPriceRuleDiscount = new CartPriceRuleDiscount;
        $this->cartPriceRuleDiscount->setProduct($this->product);
        $this->cartPriceRuleDiscount->setQuantity(1);
    }

    public function testGetters()
    {
        $this->assertEquals(null, $this->cartPriceRuleDiscount->getId());
        $this->assertEquals($this->product, $this->cartPriceRuleDiscount->getProduct());
        $this->assertEquals(1, $this->cartPriceRuleDiscount->getQuantity());
    }
}
