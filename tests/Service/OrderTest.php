<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class OrderTest extends Helper\DoctrineTestCase
{
    /* @var Order */
    protected $orderService;

    /* @var Entity\Order */
    protected $order;

    /* @var Entity\Product */
    protected $productShirt;

    /* @var Entity\User */
    protected $user;

    public function setUp()
    {
        $this->productShirt = new Entity\Product;
        $this->productShirt->setName('Shirt');
        $this->productShirt->setIsInventoryRequired(true);
        $this->productShirt->setIsPriceVisible(true);
        $this->productShirt->setIsActive(true);
        $this->productShirt->setIsVisible(true);
        $this->productShirt->setIsTaxable(true);
        $this->productShirt->setIsShippable(true);
        $this->productShirt->setShippingWeight(16);
        $this->productShirt->setQuantity(10);
        $this->productShirt->setUnitPrice(1200);

        $this->user = new Entity\User;
        $this->user->setStatus(Entity\User::STATUS_ACTIVE);
        $this->user->setEmail('test@example.com');
        $this->user->setUsername('test');
        $this->user->setPassword('xxxx');
        $this->user->setFirstName('John');
        $this->user->setLastName('Doe');
        $this->user->setLastLogin(new \DateTime);

        $this->entityManager->persist($this->productShirt);
        $this->entityManager->persist($this->user);
        $this->entityManager->flush();

        $this->orderService = new Order($this->entityManager);
    }

    public function addOrder()
    {
        $cart = new Entity\Cart;
        $cart->addItem($this->productShirt, 1);

        $orderAddress = new Entity\OrderAddress;
        $orderAddress->firstName = 'John';
        $orderAddress->lastName = 'Doe';
        $orderAddress->company = 'Acme Co.';
        $orderAddress->address1 = '123 Any St';
        $orderAddress->address2 = 'Ste 3';
        $orderAddress->city = 'Santa Monica';
        $orderAddress->state = 'CA';
        $orderAddress->zip5 = '90401';
        $orderAddress->zip4 = '3274';
        $orderAddress->phone = '555-123-4567';
        $orderAddress->email = 'john@example.com';

        $order = new Entity\Order($cart, new Service\Pricing);
        $order->setShippingAddress($orderAddress);
        $order->setBillingAddress($orderAddress);
        $order->setUser($this->user);
        $order->addPayment(new Entity\Payment\Cash(100));

        $chargeRequest = new Lib\PaymentGateway\ChargeRequest(
            new Entity\CreditCard('4242424242424242', '01', '2014'),
            100,
            'usd',
            'test@example.com'
        );

        $order->addPayment(new Entity\Payment\Credit($chargeRequest, new Lib\PaymentGateway\StripeStub));

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function testFindMissing()
    {
        $product = $this->orderService->find(0);
        $this->assertEquals(null, $product);
    }

    public function testFind()
    {
        $this->addOrder();

        $this->entityManager->clear();

        $order = $this->orderService->find(1);
        $this->assertEquals(1, $order->id);
    }

    public function testOrders()
    {
        $this->addOrder();
        $this->addOrder();

        $this->entityManager->clear();

        $orders = $this->orderService->getLatestOrders();
        $this->assertEquals(2, count($orders));
    }
}
