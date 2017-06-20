<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CartPriceRuleProductItemTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $product = $this->dummyData->getProduct();
        $cartPriceRuleProductItem = new CartPriceRuleProductItem($product, 1);

        $this->assertSame(1, $cartPriceRuleProductItem->getQuantity());
        $this->assertSame($product, $cartPriceRuleProductItem->getProduct());
    }

    public function testMatches()
    {
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem(null, $product, 1);

        $priceRule = new CartPriceRuleProductItem($product, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testMatchesWithLargerQuantity()
    {
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem(null, $product, 2);

        $priceRule = new CartPriceRuleProductItem($product, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testMatchReturnsFalse()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem(null, $product1, 1);

        $priceRule = new CartPriceRuleProductItem($product2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testProductDoesNotMatchByQuantity()
    {
        $product1 = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem(null, $product1, 1);

        $priceRule = new CartPriceRuleProductItem($product1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }
}
