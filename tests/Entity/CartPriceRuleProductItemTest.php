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
        $product = $this->getProduct(1);
        $cartItem = $this->dummyData->getCartItem($product, 1);

        $priceRule = new CartPriceRuleProductItem($product, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testMatchesWithLargerQuantity()
    {
        $product = $this->getProduct(1);
        $cartItem = $this->dummyData->getCartItem($product, 2);

        $priceRule = new CartPriceRuleProductItem($product, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testMatchReturnsFalse()
    {
        $product1 = $this->getProduct(1);
        $product2 = $this->getProduct(2);
        $cartItem = $this->dummyData->getCartItem($product1, 1);

        $priceRule = new CartPriceRuleProductItem($product2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testProductDoesNotMatchByQuantity()
    {
        $product1 = $this->getProduct(1);
        $cartItem = $this->dummyData->getCartItem($product1, 1);

        $priceRule = new CartPriceRuleProductItem($product1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    private function getProduct($id)
    {
        $product = $this->dummyData->getProduct($id);
        $product->setid($id);

        return $product;
    }
}
