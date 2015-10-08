<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class CartPriceRuleProductItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $priceRule = new CartPriceRuleProductItem(new Product, 1);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($priceRule));
        $this->assertTrue($priceRule->getProduct() instanceof Product);
        $this->assertTrue($priceRule->getView() instanceof View\CartPriceRuleProductItem);
    }

    private function getProduct($id)
    {
        $product = new Product;
        $product->setid($id);
        return $product;
    }

    public function testMathces()
    {
        $product = $this->getProduct(1);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);

        $priceRule = new CartPriceRuleProductItem($product, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testMatchesWithLargerQuantity()
    {
        $product = $this->getProduct(1);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $priceRule = new CartPriceRuleProductItem($product, 1);

        $this->assertTrue($priceRule->matches($cartItem));
    }

    public function testMatchReturnsFalse()
    {
        $product1 = $this->getProduct(1);
        $product2 = $this->getProduct(2);

        $cartItem = new CartItem;
        $cartItem->setProduct($product1);
        $cartItem->setQuantity(1);

        $priceRule = new CartPriceRuleProductItem($product2, 1);

        $this->assertFalse($priceRule->matches($cartItem));
    }

    public function testProductDoesNotMatchByQuantity()
    {
        $product1 = $this->getProduct(1);

        $cartItem = new CartItem;
        $cartItem->setProduct($product1);
        $cartItem->setQuantity(1);

        $priceRule = new CartPriceRuleProductItem($product1, 2);

        $this->assertFalse($priceRule->matches($cartItem));
    }
}
