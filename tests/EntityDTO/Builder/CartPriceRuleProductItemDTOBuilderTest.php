<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\Product;

class CartPriceRuleProductItemDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cartPriceRuleItem = new CartPriceRuleProductItem(new Product, 1);

        $cartPriceRuleItemDTO = $cartPriceRuleItem->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartPriceRuleItemDTO instanceof CartPriceRuleProductItemDTO);
        $this->assertTrue($cartPriceRuleItemDTO->product instanceof ProductDTO);
    }
}
