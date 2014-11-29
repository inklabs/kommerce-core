<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testIsCartItemsValid()
    {
        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setUnitPrice(1200);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setUnitPrice(500);

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
