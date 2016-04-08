<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;

class CartPriceRuleDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleProductItem(new Product, 1));
        $cartPriceRule->addItem(new CartPriceRuleTagItem(new Tag, 1));
        $cartPriceRule->addDiscount(new CartPriceruleDiscount(new Product));

        $cartPriceRuleDTO = $cartPriceRule->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartPriceRuleDTO instanceof CartPriceRuleDTO);
        $this->assertTrue($cartPriceRuleDTO->cartPriceRuleItems[0] instanceof CartPriceRuleProductItemDTO);
        $this->assertTrue($cartPriceRuleDTO->cartPriceRuleItems[1] instanceof CartPriceRuleTagItemDTO);
        $this->assertTrue($cartPriceRuleDTO->cartPriceRuleDiscounts[0] instanceof CartPriceRuleDiscountDTO);
    }
}
