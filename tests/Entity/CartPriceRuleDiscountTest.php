<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartPriceRuleDiscountTest extends DoctrineTestCase
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
        $product1 = $this->dummyData->getProduct(1);
        $product2 = $this->dummyData->getProduct(2);
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $cartPriceRuleDiscount = new CartPriceRuleDiscount($product1, 2);

        $cartPriceRuleDiscount->setQuantity(3);
        $cartPriceRuleDiscount->setCartPriceRule($cartPriceRule);
        $cartPriceRuleDiscount->setProduct($product2);

        $this->assertEntityValid($cartPriceRuleDiscount);
        $this->assertSame(3, $cartPriceRuleDiscount->getQuantity());
        $this->assertSame($product2, $cartPriceRuleDiscount->getProduct());
        $this->assertSame($cartPriceRule, $cartPriceRuleDiscount->getCartPriceRule());
    }
}
