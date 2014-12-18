<?php
namespace inklabs\kommerce\Entity\View\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRuleItem = new Entity\CartPriceRuleItem\Tag(new Entity\Tag, 1);
        $entityCartPriceRuleItem->setId(1);

        $cartPriceRuleItem = new Tag($entityCartPriceRuleItem);
        $cartPriceRuleItem
            ->withAllData();

        $this->assertTrue($cartPriceRuleItem instanceof Tag);
        $this->assertTrue($cartPriceRuleItem->tag instanceof View\Tag);
    }
}
