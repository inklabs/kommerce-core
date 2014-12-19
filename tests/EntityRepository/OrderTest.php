<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

use inklabs\kommerce\Lib\PaymentGateway\ChargeRequest;

class OrderTest extends Helper\DoctrineTestCase
{
    /**
     * @return Order
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Order');
    }

    public function setUp()
    {
        $productShirt = new Entity\Product;
        $productShirt->setName('Shirt');
        $productShirt->setIsInventoryRequired(true);
        $productShirt->setIsPriceVisible(true);
        $productShirt->setIsActive(true);
        $productShirt->setIsVisible(true);
        $productShirt->setIsTaxable(true);
        $productShirt->setIsShippable(true);
        $productShirt->setShippingWeight(16);
        $productShirt->setQuantity(10);
        $productShirt->setUnitPrice(1200);

        $cart = new Entity\Cart;
        $cart->addItem($productShirt, 1);

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

        $user = new Entity\User;
        $user->setStatus(Entity\User::STATUS_ACTIVE);
        $user->setEmail('test@example.com');
        $user->setUsername('test');
        $user->setPassword('xxxx');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setLastLogin(new \DateTime);

        $order = new Entity\Order($cart, new Service\Pricing);
        $order->setShippingAddress($orderAddress);
        $order->setBillingAddress($orderAddress);
        $order->setUser($user);
        $order->addPayment(new Entity\Payment\Cash(100));

        $chargeRequest = new ChargeRequest(
            new Entity\CreditCard('4242424242424242', '01', '2014'),
            100,
            'usd',
            'test@example.com'
        );

        $order->addPayment(new Entity\Payment\Credit($chargeRequest, new Lib\PaymentGateway\StripeStub));

        $this->entityManager->persist($productShirt);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\Order $order */
        $order = $this->getRepository()
            ->find(1);

        $this->assertEquals(1, $order->getId());
        $this->assertEquals(1, $order->getItems()[0]->getProduct()->getid());
        $this->assertEquals(1, $order->getUser()->getId());
        $this->assertEquals(1, $order->getPayments()[0]->getId());
        $this->assertEquals(2, $order->getPayments()[1]->getId());
    }
}
