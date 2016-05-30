<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\Lib\PaymentGateway;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use Ramsey\Uuid\UuidInterface;

class OrderTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $order = new Order;

        $this->assertTrue($order->getId() instanceof UuidInterface);
        $this->assertTrue($order->getCreated() instanceof DateTime);
        $this->assertSame(null, $order->getExternalId());
        $this->assertSame(null, $order->getReferenceNumber());
        $this->assertSame('0.0.0.0', $order->getIp4());
        $this->assertSame(0, $order->totalItems());
        $this->assertSame(0, $order->totalQuantity());
        $this->assertTrue($order->getStatus()->isPending());
        $this->assertSame(null, $order->getTotal());
        $this->assertSame(null, $order->getShippingAddress());
        $this->assertSame(null, $order->getBillingAddress());
        $this->assertSame(null, $order->getUser());
        $this->assertSame(null, $order->getShipmentRate());
        $this->assertSame(null, $order->getTaxRate());
        $this->assertSame(null, $order->getOrderItem(0));
        $this->assertSame(0, count($order->getOrderItems()));
        $this->assertSame(0, count($order->getCoupons()));
        $this->assertSame(0, count($order->getPayments()));
        $this->assertSame(0, count($order->getProducts()));
        $this->assertSame(0, count($order->getShipments()));
    }

    public function testCreate()
    {
        $shippingAddress = $this->dummyData->getOrderAddress();
        $billingAddress = clone $shippingAddress;

        $product = $this->dummyData->getProduct();
        $orderItem = $this->dummyData->getOrderItem($product);
        $orderItem->setQuantity(2);

        $user = $this->dummyData->getUser();
        $coupon = $this->dummyData->getCoupon();
        $shipment = $this->dummyData->getShipment();
        $cartTotal = $this->dummyData->getCartTotal();
        $payment = $this->dummyData->getCashPayment();
        $shipmentRate = $this->dummyData->getShipmentRate();
        $taxRate = $this->dummyData->getTaxRate();

        $order = new Order;
        $order->setExternalId('CO1102-0016');
        $order->setReferenceNumber('xxx-xxxxxxx-xxxxxxx');
        $order->setIp4('10.0.0.1');
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);
        $order->setUser($user);
        $order->addCoupon($coupon);
        $order->setTaxRate($taxRate);
        $order->setTotal($cartTotal);
        $order->addShipment($shipment);
        $order->setShipmentRate($shipmentRate);
        $order->addOrderItem($orderItem);
        $order->addPayment($payment);

        $this->assertEntityValid($order);
        $this->assertSame('CO1102-0016', $order->getExternalId());
        $this->assertSame('xxx-xxxxxxx-xxxxxxx', $order->getReferenceNumber());
        $this->assertSame('10.0.0.1', $order->getIp4());
        $this->assertTrue($order->getStatus()->isShipped());
        $this->assertSame(1, $order->totalItems());
        $this->assertSame(2, $order->totalQuantity());
        $this->assertSame($cartTotal, $order->getTotal());
        $this->assertSame($shippingAddress, $order->getShippingAddress());
        $this->assertSame($billingAddress, $order->getBillingAddress());
        $this->assertSame($user, $order->getUser());
        $this->assertSame($coupon, $order->getCoupons()[0]);
        $this->assertSame($orderItem, $order->getOrderItem(0));
        $this->assertSame($orderItem, $order->getOrderItems()[0]);
        $this->assertSame($payment, $order->getPayments()[0]);
        $this->assertSame($shipmentRate, $order->getShipmentRate());
        $this->assertSame($taxRate, $order->getTaxRate());
        $this->assertSame($product, $order->getProducts()[0]);
        $this->assertSame($shipment, $order->getShipments()[0]);
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
            'Test Catalog Promotion, Buy 1 or more for 5% off',
            $order->getOrderItems()[0]->getDiscountNames()
        );
    }

    public function testAddShipmentChangesOrderStatusToShipped()
    {
        $orderItem = $this->dummyData->getOrderItem();
        $orderItem->setQuantity(2);
        $shipment = $this->dummyData->getShipment();
        $shipmentItem = $this->dummyData->getShipmentItem($shipment, $orderItem, 2);
        $order = new Order;
        $order->addOrderItem($orderItem);

        $this->assertFalse($order->getStatus()->isShipped());
        $order->addShipment($shipment);

        $this->assertTrue($order->getStatus()->isShipped());
    }

    public function testAddShipmentChangesOrderStatusToPartiallyShipped()
    {
        $orderItem = $this->dummyData->getOrderItem();
        $orderItem->setQuantity(2);
        $shipment = $this->dummyData->getShipment();
        $this->dummyData->getShipmentItem($shipment, $orderItem, 1);

        $order = new Order;
        $order->addOrderItem($orderItem);

        $this->assertFalse($order->getStatus()->isPartiallyShipped());
        $order->addShipment($shipment);

        $this->assertTrue($order->getStatus()->isPartiallyShipped());
    }
}
