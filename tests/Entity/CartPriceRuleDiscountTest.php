<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Entity as Entity;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cartPriceRuleDiscount = new CartPriceRuleDiscount(new Product);
        $cartPriceRuleDiscount->setId(1);
        $cartPriceRuleDiscount->setQuantity(2);
        $cartPriceRuleDiscount->setCartPriceRule(new Entity\CartPriceRule);
        $cartPriceRuleDiscount->setProduct(new Product);

        $this->assertSame(1, $cartPriceRuleDiscount->getId());
        $this->assertSame(2, $cartPriceRuleDiscount->getQuantity());
        $this->assertTrue($cartPriceRuleDiscount->getProduct() instanceof Product);
        $this->assertTrue($cartPriceRuleDiscount->getCartPriceRule() instanceof CartPriceRule);
        $this->assertTrue($cartPriceRuleDiscount->getView() instanceof View\CartPriceRuleDiscount);
    }
}
