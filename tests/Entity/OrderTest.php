<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Lib\PaymentGateway;

class OrderTest extends Helper\DoctrineTestCase
{
    public function testCreate()
    {
        $shippingAddress = $this->dummyData->getOrderAddress();
        $billingAddress = clone $shippingAddress;

        $product = new Product;
        $product->setSku('sku');
        $product->setName('test name');
        $product->setUnitPrice(500);
        $product->setQuantity(10);

        $orderItem = new OrderItem;
        $orderItem->setProduct($product);
        $orderItem->setQuantity(2);

        $order = new Order;
        $order->setId(1);
        $order->setExternalId('CO1102-0016');
        $order->setIp4('10.0.0.1');
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);
        $order->setUser(new User);
        $order->addCoupon(new Coupon);
        $order->addPayment(new CashPayment(100));
        $order->setReferenceNumber('xxx-xxxxxxx-xxxxxxx');
        $order->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $order->setTaxRate(new TaxRate);
        $order->addOrderItem($orderItem);
        $order->setTotal(new CartTotal);
        $order->addShipment(new Shipment);

        $this->assertEntityValid($order);
        $this->assertSame(1, $order->getReferenceId());
        $this->assertSame('xxx-xxxxxxx-xxxxxxx', $order->getReferenceNumber());
        $this->assertSame('10.0.0.1', $order->getIp4());
        $this->assertSame(Order::STATUS_PARTIALLY_SHIPPED, $order->getStatus());
        $this->assertSame('Partially Shipped', $order->getStatusText());
        $this->assertSame(true, $order->isStatusPartiallyShipped());
        $this->assertSame(false, $order->isStatusShipped());
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
        $this->assertTrue($order->getPayments()[0] instanceof AbstractPayment);
        $this->assertTrue($order->getShipmentRate() instanceof ShipmentRate);
        $this->assertTrue($order->getTaxRate() instanceof TaxRate);
        $this->assertTrue($order->getProducts()[0] instanceof Product);
        $this->assertTrue($order->getShipments()[0] instanceof Shipment);
        $this->assertTrue($order->getDTOBuilder() instanceof OrderDTOBuilder);
    }

    public function testCreateFromCart()
    {
        $product = new Product;
        $product->setUnitPrice(500);

        $cartItem = new CartItem;
        $cartItem->setProduct($product);

        $cart = new Cart;
        $cart->setUser(new User);
        $cart->addCartItem($cartItem);
        $cart->addCoupon(new Coupon);
        $cart->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $cart->setTaxRate(new TaxRate);

        $cartCalculator = new CartCalculator(new Pricing);
        $ip4 = '10.0.0.1';

        $order = Order::fromCart($cart, $cartCalculator, $ip4);

        $this->assertTrue($order instanceof Order);
    }

    public function testAddShipmentChangesOrderStatusToShipped()
    {
        $orderItem = new OrderItem;
        $orderItem->setQuantity(2);

        $order = new Order;
        $order->addOrderItem($orderItem);

        $shipment = new Shipment;
        $shipment->addShipmentItem(new ShipmentItem($orderItem, 2));

        $order->addShipment($shipment);

        $this->assertSame(Order::STATUS_SHIPPED, $order->getStatus());
        $this->assertSame('Shipped', $order->getStatusText());
    }

    public function testAddShipmentChangesOrderStatusToPartiallyShipped()
    {
        $orderItem = new OrderItem;
        $orderItem->setQuantity(2);

        $order = new Order;
        $order->addOrderItem($orderItem);

        $shipment = new Shipment;
        $shipment->addShipmentItem(new ShipmentItem($orderItem, 1));

        $order->addShipment($shipment);

        $this->assertSame(Order::STATUS_PARTIALLY_SHIPPED, $order->getStatus());
        $this->assertSame('Partially Shipped', $order->getStatusText());
    }
}
