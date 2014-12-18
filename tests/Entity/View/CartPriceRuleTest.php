<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRule = new Entity\CartPriceRule;
        $entityCartPriceRule->addItem(new Entity\CartPriceRuleItem\Product(new Entity\Product, 1));
        $entityCartPriceRule->addItem(new Entity\CartPriceRuleItem\Tag(new Entity\Tag, 1));
        $entityCartPriceRule->addDiscount(new Entity\CartPriceruleDiscount(new Entity\Product));

        $cartPriceRule = CartPriceRule::factory($entityCartPriceRule)
            ->withAllData();

        $this->assertTrue($cartPriceRule instanceof CartPriceRule);
        $this->assertTrue($cartPriceRule->cartPriceRuleItems[0] instanceof CartPriceRuleItem\Product);
        $this->assertTrue($cartPriceRule->cartPriceRuleItems[1] instanceof CartPriceRuleItem\Tag);
        $this->assertTrue($cartPriceRule->cartPriceRuleDiscounts[0] instanceof CartPriceRuleDiscount);
    }
}
