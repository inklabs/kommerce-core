<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\Event\OrderShippedEvent;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;
use inklabs\kommerce\Lib\UuidInterface;

class OrderTest extends EntityTestCase
{
    public function testCreate()
    {
        $shippingAddress = $this->dummyData->getOrderAddress();
        $billingAddress = clone $shippingAddress;

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
        $order->addPayment($payment);

        $product = $this->dummyData->getProduct();
        $orderItem = $this->dummyData->getOrderItem($order, $product);
        $orderItem->setQuantity(2);

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
        $productX = $this->dummyData->getProduct('PROD-X');
        $productY = $this->dummyData->getProduct('PROD-X');
        $cartPriceRuleItem = $this->dummyData->getCartPriceRuleProductItem($productX);
        $cartPriceRuleDiscount = $this->dummyData->getCartPriceRuleDiscount($productY);

        $cartPriceRule = $this->dummyData->getCartPriceRule();
        $cartPriceRule->setName('Buy X get Y FREE');
        $cartPriceRule->addItem($cartPriceRuleItem);
        $cartPriceRule->addDiscount($cartPriceRuleDiscount);

        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $catalogPromotion->setName('10% OFF Site Wide Catalog Promotion');

        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount($productX);

        $pricing = $this->dummyData->getPricing([$catalogPromotion], [$productQuantityDiscount]);
        $pricing->setCartPriceRules([$cartPriceRule]);

        $cartCalculator = $this->dummyData->getCartCalculator($pricing);

        $user = $this->dummyData->getUser();
        $coupon = $this->dummyData->getCoupon();
        $taxRate = $this->dummyData->getTaxRate();
        $shipmentRate = $this->dummyData->getShipmentRate(1000);

        $cart = $this->dummyData->getCart();
        $cart->setUser($user);
        $cart->addCoupon($coupon);
        $cart->setTaxRate($taxRate);
        $cart->setShipmentRate($shipmentRate);

        $cartItem1 = $this->dummyData->getCartItem($cart, $productX);
        $cartItem2 = $this->dummyData->getCartItem($cart, $productY);

        $orderId = Uuid::uuid4();
        $order = Order::fromCart($orderId, $user, $cart, $cartCalculator, '10.0.0.1');

        $this->assertTrue($order instanceof Order);
        $this->assertSame('10.0.0.1', $order->getIp4());
        $this->assertSame($user, $order->getUser());
        $this->assertSame($coupon, $order->getCoupons()[0]);
        $this->assertSame($taxRate, $order->getTaxRate());
        $this->assertSame($shipmentRate, $order->getShipmentRate());

        $orderItem1 = $order->getOrderItems()[0];
        $this->assertEntitiesEqual($catalogPromotion, $orderItem1->getCatalogPromotions()[0]);
        $this->assertEntitiesEqual($productQuantityDiscount, $orderItem1->getProductQuantityDiscounts()[0]);

        $this->assertSame(
            '10% OFF Site Wide Catalog Promotion, Buy 1 or more for 5% off',
            $orderItem1->getDiscountNames()
        );

        $this->assertEntitiesEqual($cartPriceRule, $order->getCartPriceRules()[0]);
        $this->assertSame(
            'Buy X get Y FREE, 20% OFF Test Coupon',
            $order->getDiscountNames()
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

    public function testAddShipmentRaisesEvent()
    {
        $shipment = $this->dummyData->getShipment();
        $order = $this->dummyData->getOrder();
        $order->addShipment($shipment);

        /** @var OrderShippedEvent $event */
        $event = $order->releaseEvents()[0];
        $this->assertTrue($event instanceof OrderShippedEvent);
        $this->assertTrue($order->getId()->equals($event->getOrderId()));
        $this->assertTrue($shipment->getId()->equals($event->getShipmentId()));
    }
}
