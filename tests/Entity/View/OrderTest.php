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

        $entityOrder = new Entity\Order($cart, new Service\Pricing);
        $entityOrder->setShippingAddress(new Entity\OrderAddress);
        $entityOrder->setBillingAddress(new Entity\OrderAddress);
        $entityOrder->setUser(new Entity\User);
        $entityOrder->addCoupon(new Entity\Coupon);
        $entityOrder->addPayment(new Entity\Payment\Cash(100));

        $order = $entityOrder->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($order instanceof Order);
        $this->assertTrue($order->user instanceof User);
        $this->assertTrue($order->items[0] instanceof OrderItem);
        $this->assertTrue($order->coupons[0] instanceof Coupon);
        $this->assertTrue($order->payments[0] instanceof Payment\Payment);
    }
}
