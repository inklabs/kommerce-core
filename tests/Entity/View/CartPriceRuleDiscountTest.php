<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class CartPriceRuleDiscountTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRuleDiscount = new Entity\CartPriceRuleDiscount(new Entity\Product, 2);
        $entityCartPriceRuleDiscount->setId(1);

        $cartPriceRuleDiscount = new CartPriceRuleDiscount($entityCartPriceRuleDiscount);
        $cartPriceRuleDiscount
            ->withAllData();

        $this->assertTrue($cartPriceRuleDiscount instanceof CartPriceRuleDiscount);
        $this->assertTrue($cartPriceRuleDiscount->product instanceof Product);
    }
}
