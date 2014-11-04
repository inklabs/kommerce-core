<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class CartTest extends \inklabs\kommerce\tests\Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setDescription('Test product description');
        $this->product->setPrice(500);
        $this->product->setQuantity(10);
        $this->product->setIsInventoryRequired(true);
        $this->product->setIsPriceVisible(true);
        $this->product->setIsActive(true);
        $this->product->setIsVisible(true);
        $this->product->setIsTaxable(true);
        $this->product->setIsShippable(true);
        $this->product->setShippingWeight(16);
        $this->product->setRating(null);
        $this->product->setDefaultImage(null);
    }

    public function testCartPersistence()
    {
        $sessionManager = new ArraySessionManager;
        $cart = new Cart($sessionManager);

        $this->assertEquals(0, $cart->totalItems());

        $itemId = $cart->addItem($this->product, 1);
        $this->assertEquals(0, $itemId);
        $this->assertEquals(1, $cart->totalItems());

        $cart = new Cart($sessionManager);
        $this->assertEquals(1, $cart->totalItems());
    }
}
