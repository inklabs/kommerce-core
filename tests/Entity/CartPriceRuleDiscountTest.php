<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartPriceRuleDiscountTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $cartPriceRuleDiscount = new CartPriceRuleDiscount(new Product);
        $cartPriceRuleDiscount->setQuantity(2);
        $cartPriceRuleDiscount->setCartPriceRule(new CartPriceRule);
        $cartPriceRuleDiscount->setProduct(new Product);

        $this->assertEntityValid($cartPriceRuleDiscount);
        $this->assertSame(2, $cartPriceRuleDiscount->getQuantity());
        $this->assertTrue($cartPriceRuleDiscount->getProduct() instanceof Product);
        $this->assertTrue($cartPriceRuleDiscount->getCartPriceRule() instanceof CartPriceRule);
    }
}
