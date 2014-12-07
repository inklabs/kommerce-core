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

        $this->assertEquals(1, $cartPriceRuleDiscount->getId());
        $this->assertEquals(2, $cartPriceRuleDiscount->getQuantity());
        $this->assertInstanceOf('inklabs\kommerce\Entity\Product', $cartPriceRuleDiscount->getProduct());
        $this->assertInstanceOf('inklabs\kommerce\Entity\CartPriceRule', $cartPriceRuleDiscount->getCartPriceRule());
    }
}
