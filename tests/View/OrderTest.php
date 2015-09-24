<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $cart = new Entity\Cart;
        $cart->addCartItem(new Entity\CartItem);

        $orderItem = new Entity\OrderItem;
        $orderItem->setProduct(new Entity\Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice(new Entity\Price);

        $order = new Entity\Order;
        $order->addOrderItem($orderItem);
        $order->setTotal(new Entity\CartTotal);
        $order->setShippingAddress(new Entity\OrderAddress);
        $order->setBillingAddress(new Entity\OrderAddress);
        $order->setUser(new Entity\User);
        $order->addCoupon(new Entity\Coupon);
        $order->addPayment(new Entity\CashPayment(100));

        $orderView = $order->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($orderView instanceof Order);
        $this->assertTrue($orderView->shippingAddress instanceof OrderAddress);
        $this->assertTrue($orderView->billingAddress instanceof OrderAddress);
        $this->assertTrue($orderView->user instanceof User);
        $this->assertTrue($orderView->orderItems[0] instanceof OrderItem);
        $this->assertTrue($orderView->coupons[0] instanceof Coupon);
        $this->assertTrue($orderView->payments[0] instanceof \inklabs\kommerce\View\AbstractPayment);
    }
}
