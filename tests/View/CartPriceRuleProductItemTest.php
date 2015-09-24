<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\View\CartPriceRuleProductItem;

class CartPriceRuleProductItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRuleItem = new Entity\CartPriceRuleProductItem(new Entity\Product, 1);

        $cartPriceRuleItem = new CartPriceRuleProductItem($entityCartPriceRuleItem);
        $cartPriceRuleItem
            ->withAllData()
            ->export();

        $this->assertTrue($cartPriceRuleItem instanceof CartPriceRuleProductItem);
        $this->assertTrue($cartPriceRuleItem->product instanceof View\Product);
    }
}
