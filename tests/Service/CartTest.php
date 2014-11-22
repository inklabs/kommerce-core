<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class CartTest extends Helper\DoctrineTestCase
{
    private $pricing;
    private $sessionManager;
    private $cart;
    private $product;

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

        $this->entityManager->persist($this->product);
        $this->entityManager->flush();

        $this->viewProduct = Entity\View\Product::factory($this->product)
            ->export();
    }

    public function testCartPersistence()
    {
        $this->assertEquals(0, $this->cart->totalItems());

        $itemId = $this->cart->addItem($this->viewProduct, 2);
        $this->assertEquals(0, $itemId);
        $this->assertEquals(1, $this->cart->totalItems());
        $this->assertEquals(2, $this->cart->totalQuantity());

        $this->cart = new Cart($this->entityManager, $this->pricing, $this->sessionManager);
        $this->assertEquals(1, $this->cart->totalItems());
        $this->assertEquals(2, $this->cart->totalQuantity());
    }

    public function testCartPersistenceWithPriceChange()
    {
        $this->assertEquals(0, $this->cart->totalItems());

        $itemId = $this->cart->addItem($this->viewProduct, 2);

        $this->assertEquals(0, $itemId);
        $this->assertEquals(1, $this->cart->totalItems());
        $this->assertEquals(2, $this->cart->totalQuantity());
        $this->assertEquals(500, $this->cart->getItem($itemId)->product->unitPrice);

        $this->product->setUnitPrice(501);
        $this->entityManager->flush();

        $this->cart = new Cart($this->entityManager, $this->pricing, $this->sessionManager);
        $this->assertEquals(1, $this->cart->totalItems());
        $this->assertEquals(2, $this->cart->totalQuantity());
        $this->assertEquals(501, $this->cart->getItem($itemId)->product->unitPrice);
    }

    public function testGetItems()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 1);
        $itemId2 = $this->cart->addItem($this->viewProduct, 1);

        $this->assertEquals(2, count($this->cart->getItems()));
        $this->assertEquals('TST101', $this->cart->getItems()[0]->product->sku);
        $this->assertEquals('TST101', $this->cart->getItems()[1]->product->sku);
    }

    public function testGetItem()
    {
        $itemId = $this->cart->addItem($this->viewProduct, 1);
        $this->assertEquals('TST101', $this->cart->getItem(0)->product->sku);
    }

    public function testGetTotal()
    {
        $itemId = $this->cart->addItem($this->viewProduct, 1);
        $this->assertEquals(500, $this->cart->getTotal()->total);
    }

    public function testUpdateQuantity()
    {
        $itemId = $this->cart->addItem($this->viewProduct, 1);
        $this->cart->updateQuantity($itemId, 2);
        $this->assertEquals(1000, $this->cart->getTotal()->total);
    }

    /**
     * @expectedException Exception
     */
    public function testUpdateQuantityAndItemNotFound()
    {
        $this->cart->updateQuantity(1, 2);
    }

    public function testDeleteItem()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 1);
        $itemId2 = $this->cart->addItem($this->viewProduct, 1);
        $this->cart->deleteItem($itemId2);
        $this->assertEquals(500, $this->cart->getTotal()->total);
    }

    /**
     * @expectedException Exception
     */
    public function testDeleteItemAndItemNotFound()
    {
        $this->cart->deleteItem(1);
    }

    public function testGetProducts()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 1);
        $itemId2 = $this->cart->addItem($this->viewProduct, 1);

        $products = $this->cart->getProducts();
        $this->assertEquals(2, count($products));
        $this->assertEquals('TST101', $products[0]->sku);
        $this->assertEquals('TST101', $products[1]->sku);
    }

    public function testGetShippingWeight()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 2);
        $itemId2 = $this->cart->addItem($this->viewProduct, 2);

        $items = $this->cart->getItems();
        $this->assertEquals(32, $items[0]->shippingWeight);
        $this->assertEquals(32, $items[1]->shippingWeight);
        $this->assertEquals(64, $this->cart->getShippingWeight());
    }

    public function testGetShippingWeightInPounds()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 2);
        $itemId2 = $this->cart->addItem($this->viewProduct, 2);

        $items = $this->cart->getItems();
        $this->assertEquals(32, $items[0]->shippingWeight);
        $this->assertEquals(32, $items[1]->shippingWeight);
        $this->assertEquals(4, $this->cart->getShippingWeightInPounds());
    }

    public function testGetView()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 2);
        $itemId2 = $this->cart->addItem($this->viewProduct, 2);

        $uspsShippingRate = new Entity\Shipping\Rate;
        $uspsShippingRate->code = '4';
        $uspsShippingRate->name = 'Parcel Post';
        $uspsShippingRate->cost = 1000;
        $this->cart->setShippingRate($uspsShippingRate);

        $cartView = $this->cart->getView();
        $this->assertInstanceOf('inklabs\kommerce\Entity\View\Cart', $cartView);
        $this->assertEquals(2000, $cartView->cartTotal->subtotal);
        $this->assertEquals(1000, $cartView->cartTotal->shipping);
        $this->assertEquals(3000, $cartView->cartTotal->total);
        $this->assertEquals(2, count($cartView->items));
        $this->assertEquals(32, $cartView->items[0]->shippingWeight);
        $this->assertEquals(32, $cartView->items[1]->shippingWeight);
        $this->assertEquals(64, $cartView->shippingWeight);
    }
}
