<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\Product;

class CartPriceRuleDiscountDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cartPriceRuleDiscount = new CartPriceRuleDiscount(new Product, 2);

        $cartPriceRuleDiscountDTO = $cartPriceRuleDiscount->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartPriceRuleDiscountDTO instanceof CartPriceRuleDiscountDTO);
        $this->assertTrue($cartPriceRuleDiscountDTO->product instanceof ProductDTO);
    }
}
