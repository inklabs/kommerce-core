<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRuleDiscount = new Entity\CartPriceRuleDiscount(new Entity\Product, 2);

        $cartPriceRuleDiscount = new CartPriceRuleDiscount($entityCartPriceRuleDiscount);
        $cartPriceRuleDiscount
            ->withAllData()
            ->export();

        $this->assertTrue($cartPriceRuleDiscount instanceof CartPriceRuleDiscount);
        $this->assertTrue($cartPriceRuleDiscount->product instanceof Product);
    }
}
