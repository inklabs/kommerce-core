<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartPriceRuleTagItemTest extends DoctrineTestCase
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
        $tag1 = $this->getTag(1);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);
        $cartItem = $this->dummyData->getCartItem($product1, 1);

        $priceRule = new CartPriceRuleTagItem($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagMatchesWithLargerQuantity()
    {
        $tag1 = $this->getTag(1);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);
        $cartItem = $this->dummyData->getCartItem($product1, 2);

        $priceRule = new CartPriceRuleTagItem($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatch()
    {
        $tag1 = $this->getTag(1);
        $tag2 = $this->getTag(2);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = $this->dummyData->getCartItem($product1, 1);

        $priceRule = new CartPriceRuleTagItem($tag2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatchByQuantity()
    {
        $tag1 = $this->getTag(1);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);
        $cartItem = $this->dummyData->getCartItem($product1, 1);

        $priceRule = new CartPriceRuleTagItem($tag1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    private function getProduct($id)
    {
        $product = $this->dummyData->getProduct($id);
        $product->setId($id);
        return $product;
    }

    private function getTag($id)
    {
        $tag = $this->dummyData->getTag($id);
        $tag->setId($id);
        return $tag;
    }
}
