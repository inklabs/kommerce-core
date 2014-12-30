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
        $cart->addItem(new Product, 2);

        $order = new Order($cart, new Pricing);
        $order->setId(1);
        $order->setShippingAddress(new OrderAddress);
        $order->setBillingAddress(new OrderAddress);
        $order->setUser(new User);
        $order->addCoupon(new Coupon);
        $order->addPayment(new Payment\Cash(100));

        $this->assertSame(1, $order->getId());
        $this->assertSame(Order::STATUS_PENDING, $order->getStatus());
        $this->assertSame('Pending', $order->getStatusText());
        $this->assertSame(1, $order->totalItems());
        $this->assertSame(2, $order->totalQuantity());
        $this->assertTrue($order->getTotal() instanceof CartTotal);
        $this->assertTrue($order->getShippingAddress() instanceof OrderAddress);
        $this->assertTrue($order->getBillingAddress() instanceof OrderAddress);
        $this->assertTrue($order->getUser() instanceof User);
        $this->assertTrue($order->getCoupons()[0] instanceof Coupon);
        $this->assertTrue($order->getItems()[0] instanceof OrderItem);
        $this->assertTrue($order->getPayments()[0] instanceof Payment\Payment);
        $this->assertTrue($order->getView() instanceof View\Order);
    }
}
