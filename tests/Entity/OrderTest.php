<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\Helper as Helper;

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

    public function testCreateOrderWithCashPayment()
    {
        $this->order->addPayment(new CashPayment(2000));
        $this->assertEquals(1, count($this->order->getPayments()));
    }

    public function testCreateOrderWithMultipleCashPayment()
    {
        $this->order->addPayment(new CashPayment(1000));
        $this->order->addPayment(new CashPayment(1000));
        $this->assertEquals(2, count($this->order->getPayments()));
    }

    public function xtestCreateOrderWithCredit()
    {
        \Stripe::setApiKey('sk_xxxxxxxxxxxxxxxxxxxxxxxx');
        $myCard = [
            'number' => '4242424242424242',
            'exp_month' => 5,
            'exp_year' => 2015
        ];

        // $stub = $this->getMock('Stripe_Charge');
        // $stub->method('create')
        //     ->willReturn(Payment\StripeChargeStub::create());

        $charge = Helper\StripeChargeStub::create([
            'card' => $myCard,
            'amount' => 2000,
            'currency' => 'usd'
        ]);

        print_r($charge);

        // $creditPayment = new StripePayment(2000);
        // $creditPayment->addCharge();

        // $this->order->addPayment($creditPayment);
        $payments = $this->order->getPayments();
        $payment = $payments[0];
        $this->assertEquals(1, count($payments));
        $this->assertEquals(2000, $payment->getAmount());
        $this->assertEquals(88, $payment->getFee());
        $this->assertTrue($payment->getCreated() > 0);
        $this->assertEquals('4242', $payment->getCard()->getLast4());
        $this->assertEquals('Visa', $payment->getCard()->getType());
        $this->assertEquals('5', $payment->getCard()->getExpMonth());
        $this->assertEquals('2015', $payment->getCard()->getExpYear());
    }
}
