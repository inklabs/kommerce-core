<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cartPriceRule = new CartPriceRule;

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($cartPriceRule));
        $this->assertSame(0, count($cartPriceRule->getCartPriceRuleItems()));
        $this->assertSame(0, count($cartPriceRule->getCartPriceRuleDiscounts()));
        $this->assertTrue($cartPriceRule->getView() instanceof View\CartPriceRule);
    }

    public function testAdders()
    {
        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleItem\Product(new Product, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount(new Product, 1));
        $this->assertSame(1, count($cartPriceRule->getCartPriceRuleItems()));
        $this->assertSame(1, count($cartPriceRule->getCartPriceRuleDiscounts()));
    }

    public function testIsCartItemsValid()
    {
        $product = new Product;
        $product->setid(1);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleItem\Product($product, 1));

        $cartItems = [new CartItem($product, 1)];

        $this->assertTrue($cartPriceRule->isCartItemsValid($cartItems));
    }

    public function testIsCartItemsValidWithMultipleItems()
    {
        $product1 = new Product;
        $product1->setid(1);

        $product2 = new Product;
        $product2->setid(2);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleItem\Product($product1, 1));
        $cartPriceRule->addItem(new CartPriceRuleItem\Product($product2, 1));

        $cartItems = [
            new CartItem($product1, 1),
            new CartItem($product2, 1),
        ];

        $this->assertTrue($cartPriceRule->isCartItemsValid($cartItems));
    }

    public function testIsCartItemsValidReturnFalse()
    {
        $product1 = new Product;
        $product1->setid(1);

        $product2 = new Product;
        $product2->setid(2);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleItem\Product($product1, 1));

        $cartItems = [new CartItem($product2, 1)];

        $this->assertFalse($cartPriceRule->isCartItemsValid($cartItems));
    }

    public function testIsValid()
    {
        $product = new Product;
        $product->setid(1);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleItem\Product($product, 1));

        $cartItems = [new CartItem($product, 1)];

        $this->assertTrue($cartPriceRule->isValid(new \DateTime, $cartItems));
    }
}
