<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service as Service;

class CartPriceRuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCartPriceRuleProduct()
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
        $cartPriceRule->setName('Buy two Shirts (TS-NAVY-LG) get a FREE poster (PST-CKN)');
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRule\Product($productShirt, 2));
        $cartPriceRule->addItem(new CartPriceRule\Product($productPoster, 1));
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

    public function testCartPriceRuleTag()
    {
        $tagShirt = new Tag();
        $tagShirt->setId(1);
        $tagShirt->setName('Navy Shirt');

        $tagPoster = new Tag();
        $tagPoster->setId(2);
        $tagPoster->setName('Poster');

        $productShirt = new Product;
        $productShirt->setSku('TS-NAVY-LG');
        $productShirt->setName('Navy T-shirt (large)');
        $productShirt->setUnitPrice(1200);
        $productShirt->addTag($tagShirt);

        $productPoster = new Product;
        $productPoster->setSku('PST-CKN');
        $productPoster->setName('Citizen Kane (1941) Poster');
        $productPoster->setUnitPrice(500);
        $productPoster->addTag($tagPoster);

        $cartPriceRule = new CartPriceRule;
        $cartPriceRule->setName('Buy two Shirts get a FREE poster');
        $cartPriceRule->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $cartPriceRule->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $cartPriceRule->addItem(new CartPriceRule\Tag($tagShirt, 2));
        $cartPriceRule->addItem(new CartPriceRule\Tag($tagPoster, 1));
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
