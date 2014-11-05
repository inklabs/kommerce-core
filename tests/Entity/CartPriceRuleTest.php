<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->productShirt = new Product;
        $this->productShirt->setSku('TS-NAVY-LG');
        $this->productShirt->setName('Navy T-shirt (large)');
        $this->productShirt->setPrice(1200);

        $this->productPoster = new Product;
        $this->productPoster->setSku('PST-CKN');
        $this->productPoster->setName('Citizen Kane (1941) Poster');
        $this->productPoster->setPrice(500);

        $this->cartPriceRule = new CartPriceRule;
        $this->cartPriceRule->setName('Buy a Shirt get a FREE poster');
        $this->cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $this->cartPriceRule->addItem(new CartPriceRuleItem($this->productShirt, 1));
        $this->cartPriceRule->addItem(new CartPriceRuleItem($this->productPoster, 1));
        $this->cartPriceRule->addDiscount(new CartPriceRuleDiscount($this->productPoster, 1));
    }

    public function testGetters()
    {
        $this->assertEquals(2, count($this->cartPriceRule->getItems()));
        $this->assertEquals(1, count($this->cartPriceRule->getDiscounts()));
    }

    public function testIsCartItemsValid()
    {
        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setPrice(1200);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setPrice(500);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy two Shirts get a FREE poster');
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRuleItem($productShirt, 2));
        $cartPriceRule->addItem(new CartPriceRuleItem($productPoster, 1));
        $cartPriceRule->addDiscount(new CartPriceRuleDiscount($productPoster, 1));

        $pricing = new Service\Pricing;

        $cart = new Cart;
        $cartItems = $cart->getItems();
        $this->assertFalse($cartPriceRule->isCartItemsValid($cartItems));

        $cart = new Cart($pricing);
        $cart->addItem($productShirt, 1);
        $cartItems = $cart->getItems();
        $this->assertFalse($cartPriceRule->isCartItemsValid($cartItems));

        $cart = new Cart($pricing);
        $cart->addItem($productShirt, 1);
        $cart->addItem($productPoster, 1);
        $cartItems = $cart->getItems();
        $this->assertFalse($cartPriceRule->isCartItemsValid($cartItems));

        $cart = new Cart($pricing);
        $cart->addItem($productShirt, 2);
        $cart->addItem($productPoster, 1);
        $cartItems = $cart->getItems();
        $this->assertTrue($cartPriceRule->isCartItemsValid($cartItems));
    }
}
