<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Entity\Payment as Payment;

class CartTest extends Helper\DoctrineTestCase
{
    /* @var Cart */
    protected $cart;
    protected $pricing;
    protected $sessionManager;

    /* @var Entity\Product */
    protected $product;
    protected $viewProduct;

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

    public function testCartPersistenceWithCoupons()
    {
        $coupon = new Entity\Coupon;
        $coupon->setCode('20PCT');
        $coupon->setName('20% Off');
        $coupon->setType('percent');
        $coupon->setValue(20);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $this->cart->addCoupon($coupon->getCode());
        $this->assertEquals(1, count($this->cart->getCoupons()));

        $cart = new Cart($this->entityManager, $this->pricing, $this->sessionManager);
        $this->assertEquals(1, count($cart->getCoupons()));
    }

    /**
     * @expectedException \Exception
     */
    public function testAddItemMissing()
    {
        $this->viewProduct->id = 999;
        $itemId1 = $this->cart->addItem($this->viewProduct, 1);
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

    public function testGetTotalWithShipping()
    {
        $itemId = $this->cart->addItem($this->viewProduct, 1);

        $uspsShippingRate = new Entity\Shipping\Rate;
        $uspsShippingRate->code = '4';
        $uspsShippingRate->name = 'Parcel Post';
        $uspsShippingRate->cost = 1000;
        $this->cart->setShippingRate($uspsShippingRate);

        $this->assertEquals(1500, $this->cart->getTotal()->total);
    }

    public function testGetTotalWithTax()
    {
        $itemId = $this->cart->addItem($this->viewProduct, 1);

        $taxRate = new Entity\TaxRate;
        $taxRate->setState(null);
        $taxRate->setZip5(92606);
        $taxRate->setZip5From(null);
        $taxRate->setZip5To(null);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(true);
        $this->cart->setTaxRate($taxRate);

        $this->assertEquals(540, $this->cart->getTotal()->total);
    }

    public function testGetTotalWithShippingAndTax()
    {
        $itemId = $this->cart->addItem($this->viewProduct, 1);

        $uspsShippingRate = new Entity\Shipping\Rate;
        $uspsShippingRate->code = '4';
        $uspsShippingRate->name = 'Parcel Post';
        $uspsShippingRate->cost = 1000;
        $this->cart->setShippingRate($uspsShippingRate);

        $taxRate = new Entity\TaxRate;
        $taxRate->setState(null);
        $taxRate->setZip5(92606);
        $taxRate->setZip5From(null);
        $taxRate->setZip5To(null);
        $taxRate->setRate(8.0);
        $taxRate->setApplyToShipping(true);
        $this->cart->setTaxRate($taxRate);

        $this->assertEquals(1620, $this->cart->getTotal()->total);
    }

    public function testUpdateQuantity()
    {
        $itemId = $this->cart->addItem($this->viewProduct, 1);
        $this->cart->updateQuantity($itemId, 2);
        $this->assertEquals(1000, $this->cart->getTotal()->total);
    }

    /**
     * @expectedException \Exception
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
     * @expectedException \Exception
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

    public function testAddCoupon()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 2);

        $coupon = new Entity\Coupon;
        $coupon->setCode('20PCT');
        $coupon->setName('20% Off');
        $coupon->setType('percent');
        $coupon->setValue(20);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $this->cart->addCoupon($coupon->getCode());

        $this->assertEquals(800, $this->cart->getTotal()->total);
    }

    /**
     * @expectedException \Exception
     */
    public function testAddCouponMissing()
    {
        $this->cart->addCoupon('xxx');
    }

    public function testRemoveCoupon()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 2);

        $coupon = new Entity\Coupon;
        $coupon->setCode('20PCT');
        $coupon->setName('20% Off');
        $coupon->setType('percent');
        $coupon->setValue(20);
        $coupon->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $coupon->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();

        $this->cart->addCoupon($coupon->getCode());
        $this->assertEquals(800, $this->cart->getTotal()->total);
        $this->cart->removeCoupon(0);
        $this->assertEquals(1000, $this->cart->getTotal()->total);
    }

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

    public function testCreateOrderWithCashPayment()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 4);

        $shippingAddress = $this->getShippingAddress();
        $order = $this->cart->createOrder(new Payment\Cash(2000), $shippingAddress);
        unset($order);

        $payment = $this->entityManager->getRepository('inklabs\kommerce\Entity\Payment\Payment')->find(1);
        $this->assertEquals(1, $payment->getId());
        $this->assertEquals(1, $payment->getOrder()->getId());
        $this->assertEquals(2000, $payment->getAmount());
    }

    public function testCreateOrderWithCreditCardPayment()
    {
        $itemId1 = $this->cart->addItem($this->viewProduct, 4);

        $chargeRequest = new Lib\PaymentGateway\ChargeRequest(
            new Entity\CreditCard('4242424242424242', 5, 2015),
            2000,
            'usd',
            'test@example.com'
        );
        $creditPayment = new Payment\Credit($chargeRequest, new Lib\PaymentGateway\StripeStub);

        $shippingAddress = $this->getShippingAddress();
        $order = $this->cart->createOrder($creditPayment, $shippingAddress);
        unset($order);

        /** @var Payment\Credit $payment */
        $payment = $this->entityManager->getRepository('inklabs\kommerce\Entity\Payment\Payment')->find(1);
        $charge = $payment->getCharge();
        $this->assertEquals(1, $payment->getId());
        $this->assertEquals(1, $payment->getOrder()->getId());
        $this->assertEquals(2000, $payment->getAmount());
        $this->assertEquals(2000, $charge->getAmount());
        $this->assertEquals(88, $charge->getFee());
        $this->assertEquals('usd', $charge->getCurrency());
        $this->assertEquals('test@example.com', $charge->getDescription());
        $this->assertEquals('ch_xxxxxxxxxxxxxx', $charge->getId());
        $this->assertEquals('4242', $charge->getLast4());
        $this->assertTrue($charge->getCreated() > 0);
    }

    public function testCreateOrderWithAllOptions()
    {
        $user = new Entity\User;
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setEmail('test@example.com');
        $user->setUsername('test');
        $user->setPassword('qwerty');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $userService = new User($this->entityManager, $this->sessionManager);
        $userService->login('test', 'qwerty');
        $this->cart->setUser($userService->getUser());

        $itemId1 = $this->cart->addItem($this->viewProduct, 4);

        $chargeRequest = new Lib\PaymentGateway\ChargeRequest(
            new Entity\CreditCard('4242424242424242', 5, 2015),
            2000,
            'usd',
            'test@example.com'
        );
        $creditPayment = new Payment\Credit($chargeRequest, new Lib\PaymentGateway\StripeStub);

        $shippingAddress = $this->getShippingAddress();
        $order = $this->cart->createOrder($creditPayment, $shippingAddress);
        unset($order);

        /** @var Entity\Order $order*/
        $order = $this->entityManager->getRepository('inklabs\kommerce\Entity\Order')->find(1);
        $expectedTotal = new Entity\CartTotal;
        $expectedTotal->origSubtotal = 2000;
        $expectedTotal->subtotal = 2000;
        $expectedTotal->taxSubtotal = 2000;
        $expectedTotal->shipping = 0;
        $expectedTotal->discount = 0;
        $expectedTotal->tax = 0;
        $expectedTotal->total = 2000;
        $expectedTotal->savings = 0;
        $expectedTotal->taxRate = null;

        $this->assertEquals(1, $order->getId());
        $this->assertEquals(1, $order->getUser()->getId());
        $this->assertEquals($expectedTotal, $order->getTotal());

        /** @var Payment\Credit $payment */
        $payment = $order->getPayments()[0];

        $this->assertEquals(1, $payment->getId());
        $this->assertEquals(1, $payment->getOrder()->getId());
        $this->assertEquals(2000, $payment->getAmount());
        $this->assertEquals(2000, $payment->getCharge()->getAmount());
    }
}
