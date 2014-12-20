<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Entity\Payment as Payment;

class CartTest extends Helper\DoctrineTestCase
{
    /* @var Entity\Product */
    protected $product;

    /* @var Entity\Coupon */
    protected $coupon;

    public function testCreate()
    {
        $viewProduct = $this->getViewProduct();
        $this->setCoupon();

        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);

        $cart->setShippingRate(new Entity\Shipping\FedexRate);
        $cart->setTaxRate(new Entity\TaxRate);
        $cart->setUser(new Entity\User);

        $cart->addCouponByCode($this->coupon->getCode());

        $itemId1 = $cart->addItem($viewProduct, 1);
        $itemId2 = $cart->addItem($viewProduct, 1);

        $cart->updateQuantity($itemId1, 2);
        $cart->deleteItem($itemId2);

        $this->assertEquals(1, $cart->totalItems());
        $this->assertEquals(2, $cart->totalQuantity());
        $this->assertEquals(32, $cart->getShippingWeight());
        $this->assertEquals(2, $cart->getShippingWeightInPounds());
        $this->assertTrue($cart->getTotal() instanceof Entity\CartTotal);
        $this->assertTrue($cart->getCoupons()[0] instanceof Entity\Coupon);
        $this->assertTrue($cart->getItems()[0] instanceof Entity\View\CartItem);
        $this->assertTrue($cart->getItem(0) instanceof Entity\View\CartItem);
        $this->assertTrue($cart->getProducts()[0] instanceof Entity\View\Product);
        $this->assertTrue($cart->getView() instanceof Entity\View\Cart);
    }

    /**
     * @return Entity\View\Product
     */
    private function getViewProduct()
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

        $this->entityManager->persist($this->product);
        $this->entityManager->flush();

        return $this->product->getView()
            ->export();
    }

    /**
     * @return Entity\Coupon
     */
    private function setCoupon()
    {
        $this->coupon = new Entity\Coupon;
        $this->coupon->setCode('20PCT');
        $this->coupon->setName('20% Off');
        $this->coupon->setType('percent');
        $this->coupon->setValue(20);
        $this->coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $this->coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->entityManager->persist($this->coupon);
        $this->entityManager->flush();
    }

    /**
     * @return Entity\User
     */
    private function setUser()
    {
        $this->user = new Entity\User;
        $this->user->setFirstName('John');
        $this->user->setLastName('Doe');
        $this->user->setEmail('test@example.com');
        $this->user->setUsername('test');
        $this->user->setPassword('qwerty');

        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }

    public function testCartPersistence()
    {
        $sessionManager = new Lib\ArraySessionManager;

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $this->assertEquals(0, $cart->totalItems());

        $viewProduct = $this->getViewProduct();
        $itemId1 = $cart->addItem($viewProduct, 1);
        $this->assertEquals(1, $cart->totalItems());

        $this->entityManager->clear();

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $this->assertEquals(1, $cart->totalItems());
    }

    public function testCartPersistenceWithPriceChange()
    {
        $sessionManager = new Lib\ArraySessionManager;
        $viewProduct = $this->getViewProduct();

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $itemId = $cart->addItem($viewProduct, 2);
        $this->assertEquals(500, $cart->getItem($itemId)->product->unitPrice);

        $this->product->setUnitPrice(501);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $this->assertEquals(501, $cart->getItem($itemId)->product->unitPrice);
    }

    public function testCartPersistenceWithCouponChange()
    {
        $this->setCoupon();

        $sessionManager = new Lib\ArraySessionManager;

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $cart->addCouponByCode($this->coupon->getCode());
        $this->assertEquals(20, $cart->getCoupons()[0]->getValue());

        $this->coupon->setValue(10);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $cart = new Cart($this->entityManager, new Pricing, $sessionManager);
        $this->assertEquals(10, $cart->getCoupons()[0]->getValue());
    }

    /**
     * @expectedException \Exception
     */
    public function testAddItemMissing()
    {
        $viewProduct = $this->getViewProduct();
        $viewProduct->id = 999;

        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->addItem($viewProduct, 1);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateQuantityAndItemNotFound()
    {
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->updateQuantity(1, 2);
    }

    /**
     * @expectedException \Exception
     */
    public function testDeleteItemAndItemNotFound()
    {
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->deleteItem(1);
    }

    /**
     * @expectedException \Exception
     */
    public function testAddCouponMissing()
    {
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $cart->addCouponByCode('xxx');
    }

    public function testDeleteCoupon()
    {
        $this->setCoupon();
        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $couponId = $cart->addCouponByCode($this->coupon->getCode());
        $cart->removeCoupon($couponId);

        $this->assertEquals(0, count($cart->getCoupons()));
    }

    /**
     * @return Entity\OrderAddress
     */
    private function getShippingAddress()
    {
        $shippingAddress = new Entity\OrderAddress;
        $shippingAddress->firstName = 'John';
        $shippingAddress->lastName = 'John';
        $shippingAddress->company = 'Lawn and Order';
        $shippingAddress->address1 = '123 any st';
        $shippingAddress->address2 = 'Ste 3';
        $shippingAddress->city = 'Santa Monica';
        $shippingAddress->state = 'CA';
        $shippingAddress->zip5 = '90401';
        $shippingAddress->zip4 = null;
        $shippingAddress->phone = '5551234567';
        $shippingAddress->email = 'john.doe@example.com';

        return $shippingAddress;
    }

    public function testCreateOrder()
    {
        $viewProduct = $this->getViewProduct();
        $this->setCoupon();
        $this->setUser();

        $cart = new Cart($this->entityManager, new Pricing, new Lib\ArraySessionManager);
        $itemId1 = $cart->addItem($viewProduct, 4);
        $cart->addCouponByCode($this->coupon->getCode());
        $cart->setUser($this->user);

        $shippingAddress = $this->getShippingAddress();
        $order = $cart->createOrder(new Payment\Cash(1600), $shippingAddress);

        $this->entityManager->clear();

        /* @var Entity\Order $order */
        $order = $this->entityManager->getRepository('kommerce:Order')->find(1);
        $this->assertEquals(1, $order->getId());
        $this->assertEquals(1600, $order->getTotal()->total);

        $payment = $this->entityManager->getRepository('kommerce:Payment\Payment')->find(1);
        $this->assertEquals(1, $payment->getId());
        $this->assertEquals(1600, $payment->getAmount());
    }
}
