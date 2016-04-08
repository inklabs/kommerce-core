<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartPriceRuleDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $cartPriceRule->addItem($this->dummyData->getCartPriceRuleProductItem());
        $cartPriceRule->addItem($this->dummyData->getCartPriceRuleTagItem());
        $cartPriceRule->addDiscount($this->dummyData->getCartPriceRuleDiscount());

        $cartPriceRuleDTO = $cartPriceRule->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartPriceRuleDTO instanceof CartPriceRuleDTO);
        $this->assertTrue($cartPriceRuleDTO->cartPriceRuleItems[0] instanceof CartPriceRuleProductItemDTO);
        $this->assertTrue($cartPriceRuleDTO->cartPriceRuleItems[1] instanceof CartPriceRuleTagItemDTO);
        $this->assertTrue($cartPriceRuleDTO->cartPriceRuleDiscounts[0] instanceof CartPriceRuleDiscountDTO);
    }
}
