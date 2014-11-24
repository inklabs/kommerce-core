<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Lib\PaymentGateway;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $product = new Product;
        $product->setSku('TST101');
        $product->setName('Test Product');
        $product->setUnitPrice(500);

        $cart = new Cart;
        $cart->addItem($product, 2);
        $cart->addItem($product, 2);

        $shippingAddress = new OrderAddress;
        $shippingAddress->firstName = 'John';
        $shippingAddress->lastName = 'John';
        $shippingAddress->company = 'Lawn and Order';
        $shippingAddress->address1 = '123 any st';
        $shippingAddress->address2 = 'Ste 3';
        $shippingAddress->city = 'Santa Monica';
        $shippingAddress->state = 'CA';
        $shippingAddress->zip5 = '90401';
        $shippingAddress->zip4 = null;
        $shippingAddress->phone = '5551234567';
        $shippingAddress->email = 'john.doe@example.com';

        $billingAddress = clone $shippingAddress;

        $this->order = new Order($cart, new Pricing);
        $this->order->setStatus('pending');
        $this->order->setShippingAddress($shippingAddress);
        $this->order->setBillingAddress($billingAddress);
    }

    public function testCreateOrder()
    {
        $orderTotal = $this->order->getTotal();
        $this->assertEquals(2000, $orderTotal->total);

        $orderItems = $this->order->getItems();
        $this->assertEquals(2, count($orderItems));
        $this->assertEquals(1000, $orderItems[0]->getPrice()->quantityPrice);
    }

    /**
     * @expectedException Exception
     */
    public function testCreateOrderWithUnsupportedPayment()
    {
        $this->order->addPayment(new Helper\PaymentTypeStub(2000));
    }

    public function testCreateOrderWithCashPayment()
    {
        $this->order->addPayment(new Payment\Cash(2000));
        $this->assertEquals(1, count($this->order->getCashPayments()));
    }

    public function testCreateOrderWithMultipleCashPayment()
    {
        $this->order->addPayment(new Payment\Cash(1000));
        $this->order->addPayment(new Payment\Cash(1000));
        $this->assertEquals(2, count($this->order->getCashPayments()));
    }

    public function testCreateOrderWithCreditCard()
    {
        $chargeRequest = new PaymentGateway\ChargeRequest(
            new CreditCard('4242424242424242', 5, 2015),
            2000,
            'usd',
            'test@example.com'
        );
        $creditPayment = new Payment\Credit($chargeRequest, new PaymentGateway\StripeStub);

        $this->order->addPayment($creditPayment);

        $payments = $this->order->getCreditPayments();
        $payment = $payments[0];
        $charge = $payment->getCharge();

        $this->assertEquals(1, count($payments));
        $this->assertEquals(2000, $payment->getAmount());
        $this->assertEquals(2000, $charge->getAmount());
        $this->assertEquals(88, $charge->getFee());
        $this->assertEquals('usd', $charge->getCurrency());
        $this->assertEquals('test@example.com', $charge->getDescription());
        $this->assertEquals('ch_xxxxxxxxxxxxxx', $charge->getId());
        $this->assertTrue($charge->getCreated() > 0);
    }
}
