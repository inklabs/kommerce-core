<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class CartPriceRuleTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $cartPriceRule = new CartPriceRule;

        $this->assertSame(0, count($cartPriceRule->getCartPriceRuleItems()));
        $this->assertSame(0, count($cartPriceRule->getCartPriceRuleDiscounts()));
    }

    public function testCreate()
    {
        $item = $this->dummyData->getCartPriceRuleProductItem();
        $discount = $this->dummyData->getCartPriceRuleDiscount();

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem($item);
        $cartPriceRule->addDiscount($discount);

        $this->assertEntityValid($cartPriceRule);
        $this->assertSame($item, $cartPriceRule->getCartPriceRuleItems()[0]);
        $this->assertSame($discount, $cartPriceRule->getCartPriceRuleDiscounts()[0]);
    }

    public function testIsCartItemsValid()
    {
        $product = $this->dummyData->getProduct(1);
        $product->setid(1);
        $cartPriceRuleProductItem = $this->dummyData->getCartPriceRuleProductItem($product, 1);
        $cartItem = $this->dummyData->getCartItem($product, 1);
        $cartItems = new ArrayCollection([$cartItem]);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem($cartPriceRuleProductItem);

        $this->assertTrue($cartPriceRule->areCartItemsValid($cartItems));
    }

    public function testIsCartItemsValidWithMultipleItems()
    {
        $product1 = $this->dummyData->getProduct(1);
        $product2 = $this->dummyData->getProduct(2);
        $product1->setid(1);
        $product2->setid(2);
        $cartPriceRuleProductItem1 = $this->dummyData->getCartPriceRuleProductItem($product1, 1);
        $cartPriceRuleProductItem2 = $this->dummyData->getCartPriceRuleProductItem($product2, 1);
        $cartItems = new ArrayCollection([
            $this->dummyData->getCartItem($product1, 1),
            $this->dummyData->getCartItem($product2, 1),
        ]);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem($cartPriceRuleProductItem1);
        $cartPriceRule->addItem($cartPriceRuleProductItem2);

        $this->assertTrue($cartPriceRule->areCartItemsValid($cartItems));
    }

    public function testIsCartItemsValidReturnFalse()
    {
        $product1 = $this->dummyData->getProduct(1);
        $product2 = $this->dummyData->getProduct(2);
        $product1->setid(1);
        $product2->setid(2);
        $cartPriceRuleProductItem1 = $this->dummyData->getCartPriceRuleProductItem($product1, 1);
        $cartItems = new ArrayCollection([
            $this->dummyData->getCartItem($product2, 1)
        ]);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem($cartPriceRuleProductItem1);

        $this->assertFalse($cartPriceRule->areCartItemsValid($cartItems));
    }

    public function testIsValid()
    {
        $product1 = $this->dummyData->getProduct(1);
        $product1->setid(1);
        $cartPriceRuleProductItem1 = $this->dummyData->getCartPriceRuleProductItem($product1, 1);
        $cartItems = new ArrayCollection([
            $this->dummyData->getCartItem($product1, 1)
        ]);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->addItem($cartPriceRuleProductItem1);

        $this->assertTrue($cartPriceRule->isValid(new DateTime, $cartItems));
    }
}
