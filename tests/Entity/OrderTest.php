<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Lib\PaymentGateway;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cart = new Cart;
        $cart->addItem(new Product, 1);

        $order = new Order($cart, new Pricing);
        $order->setId(1);
        $order->setShippingAddress(new OrderAddress);
        $order->setBillingAddress(new OrderAddress);
        $order->setUser(new User);
        $order->addCoupon(new Coupon);
        $order->addPayment(new Payment\Cash(100));

        $this->assertEquals(1, $order->getId());
        $this->assertTrue($order->getTotal() instanceof CartTotal);
        $this->assertTrue($order->getShippingAddress() instanceof OrderAddress);
        $this->assertTrue($order->getBillingAddress() instanceof OrderAddress);
        $this->assertTrue($order->getUser() instanceof User);
        $this->assertTrue($order->getCoupons()[0] instanceof Coupon);
        $this->assertTrue($order->getItems()[0] instanceof OrderItem);
        $this->assertTrue($order->getPayments()[0] instanceof Payment\Payment);
    }
}
