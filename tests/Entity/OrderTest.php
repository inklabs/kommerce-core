<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Lib\PaymentGateway;
use Symfony\Component\Validator\Validation;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $shippingAddress = new OrderAddress;
        $shippingAddress->firstName = 'John';
        $shippingAddress->lastName = 'Doe';
        $shippingAddress->company = 'Acme Co.';
        $shippingAddress->address1 = '123 Any St';
        $shippingAddress->address2 = 'Ste 3';
        $shippingAddress->city = 'Santa Monica';
        $shippingAddress->state = 'CA';
        $shippingAddress->zip5 = '90401';
        $shippingAddress->zip4 = '3274';
        $shippingAddress->phone = '555-123-4567';
        $shippingAddress->email = 'john@example.com';

        $billingAddress = clone $shippingAddress;

        $product = new Product;
        $product->setSku('sku');
        $product->setname('test name');
        $product->setUnitPrice(500);
        $product->setQuantity(10);

        $cart = new Cart;
        $cart->addItem($product, 2);

        $order = $cart->getOrder(new Pricing);
        $order->setId(1);
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);
        $order->setUser(new User);
        $order->addCoupon(new Coupon);
        $order->addPayment(new Payment\Cash(100));

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($order));
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
        $this->assertTrue($order->getItem(0) instanceof OrderItem);
        $this->assertTrue($order->getItems()[0] instanceof OrderItem);
        $this->assertTrue($order->getPayments()[0] instanceof Payment\Payment);
        $this->assertTrue($order->getView() instanceof View\Order);
    }
}
