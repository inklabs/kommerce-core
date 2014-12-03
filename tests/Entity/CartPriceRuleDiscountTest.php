<?php
namespace inklabs\kommerce\Entity;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cartPriceRuleDiscount = new CartPriceRuleDiscount(new Product, 1);
        $cartPriceRuleDiscount->setId(1);

        $this->assertEquals(1, $cartPriceRuleDiscount->getId());
        $this->assertEquals(1, $cartPriceRuleDiscount->getQuantity());
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $cartPriceRuleDiscount->getProduct());

        $cartPriceRuleDiscount->setProduct(new Product);
        $cartPriceRuleDiscount->setQuantity(2);
        $this->assertEquals(2, $cartPriceRuleDiscount->getQuantity());
    }
}
