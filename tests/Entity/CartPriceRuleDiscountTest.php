<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CartPriceRuleDiscountTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $product = $this->dummyData->getProduct();
        $cartPriceRuleDiscount = new CartPriceRuleDiscount($product);

        $this->assertSame(1, $cartPriceRuleDiscount->getQuantity());
        $this->assertSame($product, $cartPriceRuleDiscount->getProduct());
        $this->assertSame(null, $cartPriceRuleDiscount->getCartPriceRule());
    }

    public function testCreate()
    {
        $product = $this->dummyData->getProduct();
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $cartPriceRuleDiscount = new CartPriceRuleDiscount($product, 2);

        $cartPriceRuleDiscount->setQuantity(3);
        $cartPriceRuleDiscount->setCartPriceRule($cartPriceRule);

        $this->assertEntityValid($cartPriceRuleDiscount);
        $this->assertSame(3, $cartPriceRuleDiscount->getQuantity());
        $this->assertSame($product, $cartPriceRuleDiscount->getProduct());
        $this->assertSame($cartPriceRule, $cartPriceRuleDiscount->getCartPriceRule());
    }
}
