<?php
namespace inklabs\kommerce;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;

        $this->cartPriceRuleDiscount = new Entity\CartPriceRuleDiscount;
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
