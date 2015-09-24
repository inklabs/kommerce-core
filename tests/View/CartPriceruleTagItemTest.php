<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\View\CartPriceRuleTagItem;

class CartPriceruleTagItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRuleItem = new Entity\CartPriceRuleTagItem(new Entity\Tag, 1);

        $cartPriceRuleItem = new CartPriceRuleTagItem($entityCartPriceRuleItem);
        $cartPriceRuleItem
            ->withAllData()
            ->export();

        $this->assertTrue($cartPriceRuleItem instanceof CartPriceRuleTagItem);
        $this->assertTrue($cartPriceRuleItem->tag instanceof View\Tag);
    }
}
