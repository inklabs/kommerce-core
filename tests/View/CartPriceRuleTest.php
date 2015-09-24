<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRule = new Entity\CartPriceRule;
        $entityCartPriceRule->addItem(new Entity\CartPriceRuleProductItem(new Entity\Product, 1));
        $entityCartPriceRule->addItem(new Entity\CartPriceRuleTagItem(new Entity\Tag, 1));
        $entityCartPriceRule->addDiscount(new Entity\CartPriceruleDiscount(new Entity\Product));

        $cartPriceRule = $entityCartPriceRule->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($cartPriceRule instanceof CartPriceRule);
        $this->assertTrue(
            $cartPriceRule->cartPriceRuleItems[0] instanceof \inklabs\kommerce\View\CartPriceRuleProductItem
        );
        $this->assertTrue($cartPriceRule->cartPriceRuleItems[1] instanceof \inklabs\kommerce\View\CartPriceRuleTagItem);
        $this->assertTrue($cartPriceRule->cartPriceRuleDiscounts[0] instanceof CartPriceRuleDiscount);
    }
}
