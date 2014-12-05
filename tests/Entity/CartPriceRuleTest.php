<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cartPriceRule = new CartPriceRule;
        $this->assertEquals(0, count($cartPriceRule->getItems()));
        $this->assertEquals(0, count($cartPriceRule->getDiscounts()));
    }

    public function testAdders()
    {
        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleItem\Product(new Product, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount(new Product, 1));
        $this->assertEquals(1, count($cartPriceRule->getItems()));
        $this->assertEquals(1, count($cartPriceRule->getDiscounts()));
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
