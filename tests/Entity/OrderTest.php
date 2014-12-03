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
        $this->assertInstanceOf('inklabs\kommerce\Entity\CartTotal', $order->getTotal());
        $this->assertInstanceOf('inklabs\kommerce\Entity\OrderAddress', $order->getShippingAddress());
        $this->assertInstanceOf('inklabs\kommerce\Entity\OrderAddress', $order->getBillingAddress());
        $this->assertInstanceOf('inklabs\kommerce\Entity\User', $order->getUser());
        $this->assertInstanceOf('inklabs\kommerce\Entity\Coupon', $order->getCoupons()[0]);
        $this->assertInstanceOf('inklabs\kommerce\Entity\OrderItem', $order->getItems()[0]);
        $this->assertInstanceOf('inklabs\kommerce\Entity\Payment\Payment', $order->getPayments()[0]);
    }
}
