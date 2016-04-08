<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\Entity\Tag;

class CartPriceRuleTagItemDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cartPriceRuleItem = new CartPriceRuleTagItem(new Tag, 1);

        $cartPriceRuleItemDTO = $cartPriceRuleItem->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartPriceRuleItemDTO instanceof CartPriceRuleTagItemDTO);
        $this->assertTrue($cartPriceRuleItemDTO->tag instanceof TagDTO);
    }
}
