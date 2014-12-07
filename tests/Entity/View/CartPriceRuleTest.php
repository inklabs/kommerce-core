<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $product = new Entity\Product;

        $entityCartPriceRule = new Entity\CartPriceRule;
        $entityCartPriceRule->addItem(new Entity\CartPriceRuleItem\Product($product, 1));
        $entityCartPriceRule->addDiscount(new Entity\CartPriceruleDiscount($product));

        $cartPriceRule = CartPriceRule::factory($entityCartPriceRule)
            ->withAllData()
            ->export();

        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CartPriceRule', $cartPriceRule);
//        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CartPriceRuleItem\Item', $cartPriceRule->items[0]);
//        $this->assertInstanceOf('inklabs\kommerce\Entity\View\CartPriceRuleDiscount', $cartPriceRule->discount);
    }
}
