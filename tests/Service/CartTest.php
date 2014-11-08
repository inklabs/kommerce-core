<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class CartTest extends \inklabs\kommerce\tests\Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setDescription('Test product description');
        $this->product->setUnitPrice(500);
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
        $sessionManager = new Lib\ArraySessionManager;
        $cart = new Cart($this->entityManager, $sessionManager);

        $this->assertEquals(0, $cart->totalItems());

        $itemId = $cart->addItem($this->product, 1);
        $this->assertEquals(0, $itemId);
        $this->assertEquals(1, $cart->totalItems());

        $cart = new Cart($this->entityManager, $sessionManager);
        $this->assertEquals(1, $cart->totalItems());
    }

    public function testGetItems()
    {
        $sessionManager = new Lib\ArraySessionManager;
        $cart = new Cart($this->entityManager, $sessionManager);

        $itemId = $cart->addItem($this->product, 1);
        $itemId = $cart->addItem($this->product, 1);

        $this->assertEquals(2, count($cart->getItems()));
    }

    public function testGetItem()
    {
        $sessionManager = new Lib\ArraySessionManager;
        $cart = new Cart($this->entityManager, $sessionManager);
        $itemId = $cart->addItem($this->product, 1);

        $this->assertEquals($this->product, $cart->getItem(0)->getProduct());
    }
}
