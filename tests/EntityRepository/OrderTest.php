<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;
use inklabs\kommerce\tests\Helper as Helper;

class OrderTest extends Helper\DoctrineTestCase
{
    /**
     * @return Order
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Order');
    }

    public function setupOrder()
    {
        $product = $this->getDummyProduct();
        $orderAddress = $this->getDummyOrderAddress();
        $user = $this->getDummyUser();

        $cart = new Entity\Cart;
        $cart->addItem($product, 1);

        $order = new Entity\Order($cart, new Service\Pricing);
        $order->setShippingAddress($orderAddress);
        $order->setBillingAddress($orderAddress);
        $order->setUser($user);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function getDummyProduct()
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

        return $productShirt;
    }

    private function getDummyOrderAddress()
    {
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

        return $orderAddress;
    }

    private function getDummyUser()
    {
        $user = new Entity\User;
        $user->setStatus(Entity\User::STATUS_ACTIVE);
        $user->setEmail('test@example.com');
        $user->setUsername('test');
        $user->setPassword('xxxx');
        $user->setFirstName('John');
        $user->setLastName('Doe');

        return $user;
    }

    public function testFind()
    {
        $this->setupOrder();

        $this->setCountLogger();

        $order = $this->getRepository()
            ->find(1);

        $order->getItems()->toArray();
        $order->getpayments()->toArray();
        $order->getUser()->getEmail();
        $order->getCoupons()->toArray();

        $this->assertTrue($order instanceof Entity\Order);
        $this->assertSame(4, $this->countSQLLogger->getTotalQueries());
    }
}
