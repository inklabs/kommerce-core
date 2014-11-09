<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class CartTest extends \inklabs\kommerce\tests\Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
        $this->sessionManager = new Lib\ArraySessionManager;
        $this->cart = new Cart($this->entityManager, $this->pricing, $this->sessionManager);

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
        $this->assertEquals(0, $this->cart->totalItems());

        $itemId = $this->cart->addItem($this->product, 1);
        $this->assertEquals(0, $itemId);
        $this->assertEquals(1, $this->cart->totalItems());

        $this->cart = new Cart($this->entityManager, $this->pricing, $this->sessionManager);
        $this->assertEquals(1, $this->cart->totalItems());
    }

    public function testGetItems()
    {
        $itemId = $this->cart->addItem($this->product, 1);
        $itemId = $this->cart->addItem($this->product, 1);

        $this->assertEquals(2, count($this->cart->getItems()));
        $this->assertEquals('TST101', $this->cart->getItems()[0]->product->sku);
        $this->assertEquals('TST101', $this->cart->getItems()[1]->product->sku);
    }

    public function testGetItem()
    {
        $itemId = $this->cart->addItem($this->product, 1);
        $this->assertEquals('TST101', $this->cart->getItem(0)->product->sku);
    }

    public function testGetTotal()
    {
        $itemId = $this->cart->addItem($this->product, 1);
        $this->assertEquals(500, $this->cart->getTotal()->total);
    }
}
