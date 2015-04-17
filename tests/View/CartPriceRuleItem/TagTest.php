<?php
namespace inklabs\kommerce\View\CartPriceRuleItem;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class TagTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityCartPriceRuleItem = new Entity\CartPriceRuleItem\Tag(new Entity\Tag, 1);

        $cartPriceRuleItem = new Tag($entityCartPriceRuleItem);
        $cartPriceRuleItem
            ->withAllData()
            ->export();

        $this->assertTrue($cartPriceRuleItem instanceof Tag);
        $this->assertTrue($cartPriceRuleItem->tag instanceof View\Tag);
    }
}
