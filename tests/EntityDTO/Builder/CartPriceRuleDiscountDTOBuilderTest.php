<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartPriceRuleDiscountDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $cartPriceRuleDiscount = $this->dummyData->getCartPriceRuleDiscount();

        $cartPriceRuleDiscountDTO = $cartPriceRuleDiscount->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartPriceRuleDiscountDTO instanceof CartPriceRuleDiscountDTO);
        $this->assertTrue($cartPriceRuleDiscountDTO->product instanceof ProductDTO);
    }
}
