<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;
use Doctrine\Common\Collections\ArrayCollection;

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
    }

    public function testAdders()
    {
        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleProductItem(new Product, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount(new Product, 1));
        $this->assertSame(1, count($cartPriceRule->getCartPriceRuleItems()));
        $this->assertSame(1, count($cartPriceRule->getCartPriceRuleDiscounts()));
    }

    public function testIsCartItemsValid()
    {
        $product = new Product;
        $product->setid(1);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleProductItem($product, 1));

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);

        $cartItems = new ArrayCollection;
        $cartItems->add($cartItem);

        $this->assertTrue($cartPriceRule->isCartItemsValid($cartItems));
    }

    public function testIsCartItemsValidWithMultipleItems()
    {
        $product1 = new Product;
        $product1->setid(1);

        $product2 = new Product;
        $product2->setid(2);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleProductItem($product1, 1));
        $cartPriceRule->addItem(new CartPriceRuleProductItem($product2, 1));

        $cartItem1 = new CartItem;
        $cartItem1->setProduct($product1);
        $cartItem1->setQuantity(1);

        $cartItem2 = new CartItem;
        $cartItem2->setProduct($product2);
        $cartItem2->setQuantity(1);

        $cartItems = new ArrayCollection;
        $cartItems->add($cartItem1);
        $cartItems->add($cartItem2);

        $this->assertTrue($cartPriceRule->isCartItemsValid($cartItems));
    }

    public function testIsCartItemsValidReturnFalse()
    {
        $product1 = new Product;
        $product1->setid(1);

        $product2 = new Product;
        $product2->setid(2);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleProductItem($product1, 1));

        $cartItem = new CartItem;
        $cartItem->setProduct($product2);
        $cartItem->setQuantity(1);

        $cartItems = new ArrayCollection;
        $cartItems->add($cartItem);

        $this->assertFalse($cartPriceRule->isCartItemsValid($cartItems));
    }

    public function testIsValid()
    {
        $product = new Product;
        $product->setid(1);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem(new CartPriceRuleProductItem($product, 1));

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);

        $cartItems = new ArrayCollection;
        $cartItems->add($cartItem);

        $this->assertTrue($cartPriceRule->isValid(new \DateTime, $cartItems));
    }
}
