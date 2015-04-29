<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\tests\Helper;
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
        $product->setName('test name');
        $product->setUnitPrice(500);
        $product->setQuantity(10);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $cartItem->setQuantity(2);

        $cart = new Cart;
        $cart->setUser(new User);
        $cart->addCartItem($cartItem);

        $order = $cart->getOrder(new Pricing);
        $order->setId(1);
        $order->setExternalId('CO1102-0016');
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);
        $order->setUser(new User);
        $order->addCoupon(new Coupon);
        $order->addPayment(new Payment\Cash(100));
        $order->setReferenceNumber('xxx-xxxxxxx-xxxxxxx');

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($order));
        $this->assertSame(1, $order->getReferenceId());
        $this->assertSame('xxx-xxxxxxx-xxxxxxx', $order->getReferenceNumber());
        $this->assertSame(Order::STATUS_PENDING, $order->getStatus());
        $this->assertSame('Pending', $order->getStatusText());
        $this->assertSame('CO1102-0016', $order->getExternalId());
        $this->assertSame(1, $order->totalItems());
        $this->assertSame(2, $order->totalQuantity());
        $this->assertTrue($order->getTotal() instanceof CartTotal);
        $this->assertTrue($order->getShippingAddress() instanceof OrderAddress);
        $this->assertTrue($order->getBillingAddress() instanceof OrderAddress);
        $this->assertTrue($order->getUser() instanceof User);
        $this->assertTrue($order->getCoupons()[0] instanceof Coupon);
        $this->assertTrue($order->getOrderItem(0) instanceof OrderItem);
        $this->assertTrue($order->getOrderItems()[0] instanceof OrderItem);
        $this->assertTrue($order->getPayments()[0] instanceof Payment\Payment);
        $this->assertTrue($order->getView() instanceof View\Order);
    }
}
