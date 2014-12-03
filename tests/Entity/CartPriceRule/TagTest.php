<?php
namespace inklabs\kommerce\Entity\CartPriceRule;

use inklabs\kommerce\Entity as Entity;

class TagTestTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $priceRule = new Tag(new Entity\Tag, 1);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Tag', $priceRule->getTag());
    }

    /**
     * @return Entity\Tag
     */
    private function getTag($id)
    {
        $tag = new Entity\Tag;
        $tag->setId($id);
        return $tag;
    }

    /**
     * @return Entity\Product
     */
    private function getProduct($id)
    {
        $product = new Entity\Product();
        $product->setId($id);
        return $product;
    }

    public function testTagMatches()
    {
        $tag1 = $this->getTag(1);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new Entity\CartItem($product1, 1);
        $priceRule = new Tag($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagMatchesWithLargerQuantity()
    {
        $tag1 = $this->getTag(1);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new Entity\CartItem($product1, 2);
        $priceRule = new Tag($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatch()
    {
        $tag1 = $this->getTag(1);
        $tag2 = $this->getTag(2);

        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new Entity\CartItem($product1, 1);
        $priceRule = new Tag($tag2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatchByQuantity()
    {
        $tag1 = $this->getTag(1);

        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new Entity\CartItem($product1, 1);
        $priceRule = new Tag($tag1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testGetTag()
    {
        $tag1 = $this->getTag(1);
        $priceRule = new Tag($tag1, 1);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Tag', $priceRule->getTag());
    }
}
