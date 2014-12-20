<?php
namespace inklabs\kommerce\Entity\View\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRuleItem = new Entity\CartPriceRuleItem\Product(new Entity\Product, 1);
        $entityCartPriceRuleItem->setId(1);

        $cartPriceRuleItem = new Product($entityCartPriceRuleItem);
        $cartPriceRuleItem
            ->withAllData()
            ->export();

        $this->assertTrue($cartPriceRuleItem instanceof Product);
        $this->assertTrue($cartPriceRuleItem->product instanceof View\Product);
    }
}
