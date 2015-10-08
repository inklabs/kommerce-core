<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class CartPriceRuleTagItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $priceRule = new CartPriceRuleTagItem(new Tag, 1);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($priceRule));
        $this->assertTrue($priceRule->getTag() instanceof Tag);
        $this->assertTrue($priceRule->getView() instanceof View\CartPriceRuleTagItem);
    }

    private function getTag($id)
    {
        $tag = new Tag;
        $tag->setId($id);
        return $tag;
    }

    private function getProduct($id)
    {
        $product = new Product();
        $product->setId($id);
        return $product;
    }

    public function testTagMatches()
    {
        $tag1 = $this->getTag(1);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new CartItem;
        $cartItem->setProduct($product1);
        $cartItem->setQuantity(1);

        $priceRule = new CartPriceRuleTagItem($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagMatchesWithLargerQuantity()
    {
        $tag1 = $this->getTag(1);
        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new CartItem;
        $cartItem->setProduct($product1);
        $cartItem->setQuantity(2);

        $priceRule = new CartPriceRuleTagItem($tag1, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatch()
    {
        $tag1 = $this->getTag(1);
        $tag2 = $this->getTag(2);

        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new CartItem;
        $cartItem->setProduct($product1);
        $cartItem->setQuantity(1);

        $priceRule = new CartPriceRuleTagItem($tag2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testTagDoesNotMatchByQuantity()
    {
        $tag1 = $this->getTag(1);

        $product1 = $this->getProduct(1);
        $product1->addTag($tag1);

        $cartItem = new CartItem;
        $cartItem->setProduct($product1);
        $cartItem->setQuantity(1);

        $priceRule = new CartPriceRuleTagItem($tag1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testGetTag()
    {
        $tag1 = $this->getTag(1);
        $priceRule = new CartPriceRuleTagItem($tag1, 1);
        $this->assertTrue($priceRule->getTag() instanceof Tag);
    }
}
