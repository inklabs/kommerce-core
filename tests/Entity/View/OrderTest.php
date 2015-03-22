<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Service as Service;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cart = new Entity\Cart;
        $cart->addItem(new Entity\Product, 1);

        $orderItem = new Entity\OrderItem(new Entity\Product, 1, new Entity\Price);
        $order = new Entity\Order([$orderItem], new Entity\CartTotal);
        $order->setShippingAddress(new Entity\OrderAddress);
        $order->setBillingAddress(new Entity\OrderAddress);
        $order->setUser(new Entity\User);
        $order->addCoupon(new Entity\Coupon);
        $order->addPayment(new Entity\Payment\Cash(100));

        $orderView = $order->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($orderView instanceof Order);
        $this->assertTrue($orderView->shippingAddress instanceof OrderAddress);
        $this->assertTrue($orderView->billingAddress instanceof OrderAddress);
        $this->assertTrue($orderView->user instanceof User);
        $this->assertTrue($orderView->items[0] instanceof OrderItem);
        $this->assertTrue($orderView->coupons[0] instanceof Coupon);
        $this->assertTrue($orderView->payments[0] instanceof Payment\Payment);
    }
}
