<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
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
        $this->assertTrue($order->getStatusType()->isPartiallyShipped());
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
        $cartCalculator = $this->dummyData->getCartCalculator();
        $user = $this->dummyData->getUser();
        $coupon = $this->dummyData->getCoupon();
        $taxRate = $this->dummyData->getTaxRate();
        $shipmentRate = $this->dummyData->getShipmentRate(1000);

        $cart = $this->dummyData->getCart([
            $this->dummyData->getCartItemFull()
        ]);
        $cart->setUser($user);
        $cart->addCoupon($coupon);
        $cart->setTaxRate($taxRate);
        $cart->setShipmentRate($shipmentRate);

        $order = Order::fromCart($cart, $cartCalculator, '10.0.0.1');

        $this->assertTrue($order instanceof Order);
        $this->assertSame('10.0.0.1', $order->getIp4());
        $this->assertSame($user, $order->getUser());
        $this->assertSame($coupon, $order->getCoupons()[0]);
        $this->assertSame($taxRate, $order->getTaxRate());
        $this->assertSame($shipmentRate, $order->getShipmentRate());
        $this->assertSame(
            'Test Catalog Promotion #1, Buy 1 or more for 5% off',
            $order->getOrderItems()[0]->getDiscountNames()
        );
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

        $this->assertTrue($order->getStatusType()->isShipped());
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

        $this->assertTrue($order->getStatusType()->isPartiallyShipped());
    }
}
