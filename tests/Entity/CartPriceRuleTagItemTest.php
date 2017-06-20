<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CartPriceRuleTagItemTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $tag = $this->dummyData->getTag();
        $cartPriceRuleTagItem = new CartPriceRuleTagItem($tag, 1);

        $this->assertSame(1, $cartPriceRuleTagItem->getQuantity());
        $this->assertSame($tag, $cartPriceRuleTagItem->getTag());
    }

    public function testTagMatches()
    {
        $tag1 = $this->dummyData->getTag();
        $product1 = $this->dummyData->getProduct();
        $product1->addTag($tag1);
        $cartItem = $this->dummyData->getCartItem(null, $product1, 1);

        $priceRule = new CartPriceRuleTagItem($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagMatchesWithLargerQuantity()
    {
        $tag1 = $this->dummyData->getTag();
        $product1 = $this->dummyData->getProduct();
        $product1->addTag($tag1);
        $cartItem = $this->dummyData->getCartItem(null, $product1, 2);

        $priceRule = new CartPriceRuleTagItem($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatch()
    {
        $tag1 = $this->dummyData->getTag();
        $tag2 = $this->dummyData->getTag();
        $product1 = $this->dummyData->getProduct();
        $product1->addTag($tag1);

        $cartItem = $this->dummyData->getCartItem(null, $product1, 1);

        $priceRule = new CartPriceRuleTagItem($tag2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatchByQuantity()
    {
        $tag1 = $this->dummyData->getTag();
        $product1 = $this->dummyData->getProduct();
        $product1->addTag($tag1);
        $cartItem = $this->dummyData->getCartItem(null, $product1, 1);

        $priceRule = new CartPriceRuleTagItem($tag1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }
}
