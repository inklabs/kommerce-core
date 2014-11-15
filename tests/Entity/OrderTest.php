<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;

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
}
