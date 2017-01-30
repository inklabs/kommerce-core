<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\ReferenceNumber\HashSegmentReferenceNumberGenerator;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class OrderRepositoryTest extends EntityRepositoryTestCase
{
    /** @var OrderRepositoryInterface */
    protected $orderRepository;

    protected $metaDataClassNames = [
        AbstractPayment::class,
        Attachment::class,
        Cart::class,
        CartPriceRule::class,
        CatalogPromotion::class,
        Coupon::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionProduct::class,
        OrderItemOptionValue::class,
        OrderItemTextOptionValue::class,
        OptionProduct::class,
        OptionValue::class,
        Product::class,
        ProductQuantityDiscount::class,
        Shipment::class,
        ShipmentTracker::class,
        ShipmentItem::class,
        ShipmentComment::class,
        Tag::class,
        TaxRate::class,
        TextOption::class,
        User::class,
    ];

    public function setUp()
    {
        parent::setUp();
        $this->orderRepository = $this->getRepositoryFactory()->getOrderRepository();
    }

    public function testCRUD()
    {
        $user = $this->dummyData->getUser();
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $order = $this->dummyData->getOrder();
        $order->setUser($user);

        $this->executeRepositoryCRUD(
            $this->orderRepository,
            $order
        );
    }

    public function testFindOneById()
    {
        $originalOrder = $this->setupOrderForFind();
        $this->entityManager->clear();

        $this->setCountLogger();

        $order = $this->orderRepository->findOneById(
            $originalOrder->getId()
        );

        $order->getUser()->getCreated();
        $order->getTaxRate()->getCreated();
        $this->visitElements($order->getOrderItems());
        $this->visitElements($order->getPayments());
        $this->visitElements($order->getCoupons());
        $this->visitElements($order->getCartPriceRules());

        $shipment = $order->getShipments()[0];
        $this->visitElements($shipment->getShipmentTrackers());
        $this->visitElements($shipment->getShipmentItems());
        $this->visitElements($shipment->getShipmentComments());

        $orderItem = $order->getOrderItem(0);
        $orderItem->getProduct()->getCreated();
        $orderItem->getOrder()->getCreated();
        $this->visitElements($orderItem->getCatalogPromotions());
        $this->visitElements($orderItem->getProductQuantityDiscounts());
        $this->visitElements($orderItem->getOrderItemOptionProducts());
        $this->visitElements($orderItem->getOrderItemOptionValues());
        $this->visitElements($orderItem->getOrderItemTextOptionValues());

        $this->assertEquals($originalOrder->getId(), $order->getId());
        $this->assertSame('Test Cart Price Rule', $order->getDiscountNames());
        $this->assertCount(1, $orderItem->getAttachments());
        $this->assertSame(16, $this->getTotalQueries());
    }

    private function setupOrderForFind($referenceNumber = null)
    {
        $uniqueId = crc32($referenceNumber);

        $product = $this->dummyData->getProduct();
        $product->enableAttachments();

        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount($product);

        $user = $this->dummyData->getUser($uniqueId);

        $price = $this->dummyData->getPrice();
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);

        $cartPriceRule = $this->dummyData->getCartPriceRule();

        $cartTotal = $this->dummyData->getCartTotal();
        $cartTotal->addCartPriceRule($cartPriceRule);

        $taxRate = $this->dummyData->getTaxRate();

        $order = $this->dummyData->getOrder($cartTotal);
        $order->setUser($user);
        $order->setReferenceNumber($referenceNumber);
        $order->setTaxRate($taxRate);

        $attachmentForOrderItem = $this->dummyData->getAttachment();
        $orderItem = $this->dummyData->getOrderItem($order, $product, $price);
        $orderItem->addAttachment($attachmentForOrderItem);

        $shipment = $this->dummyData->getShipment();
        $shipmentItem = $this->dummyData->getShipmentItem($shipment, $orderItem, 1);

        $order->addShipment($shipment);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($productQuantityDiscount);
        $this->entityManager->persist($cartPriceRule);
        $this->entityManager->persist($product);
        $this->entityManager->persist($attachmentForOrderItem);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);

        $this->orderRepository->create($order);

        $this->entityManager->flush();

        return $order;
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Order not found'
        );

        $this->orderRepository->findOneById(
            $this->dummyData->getId()
        );
    }

    public function testGetLatestOrders()
    {
        $order1 = $this->setupOrder(1);
        $order2 = $this->setupOrder(2);

        $orders = $this->orderRepository->getLatestOrders();

        $this->assertTrue($orders[0]->getCreated()->getTimestamp() >= $orders[1]->getCreated()->getTimestamp());
    }

    public function testCreateWithHashReferenceNumber()
    {
        $this->seedRandomNumberGenerator();

        $this->orderRepository = $this->getRepositoryFactory()->getOrderWithHashSegmentGenerator();

        $order = $this->setupOrder();

        $this->assertSame('963-1273124-1535857', $order->getReferenceNumber());
    }

    public function testCreateWithHashReferenceNumberAndDuplicateFailure()
    {
        $this->seedRandomNumberGenerator();

        // Simulate 3 duplicates in a row.
        $this->setupOrder('963-1273124-1535857');
        $this->setupOrder('324-1294424-1842424');
        $this->setupOrder('117-1819459-9097917');

        $this->orderRepository->setReferenceNumberGenerator(
            new HashSegmentReferenceNumberGenerator($this->orderRepository)
        );

        $order = $this->setupOrder();

        $this->assertSame(null, $order->getReferenceNumber());
    }

    public function testGetOrdersByUserId()
    {
        $originalOrder = $this->setupOrder();
        $originalUser = $originalOrder->getUser();

        $orders = $this->orderRepository->getOrdersByUserId(
            $originalUser->getId()
        );

        $this->assertEquals($originalOrder->getId(), $orders[0]->getId());
        $this->assertEquals($originalUser->getId(), $orders[0]->getUser()->getId());
    }

    private function setupOrder($referenceNumber = null)
    {
        $uniqueId = crc32($referenceNumber);

        $product = $this->dummyData->getProduct();
        $price = $this->dummyData->getPrice();
        $user = $this->dummyData->getUser($uniqueId);
        $cartTotal = $this->dummyData->getCartTotal();
        $taxRate = $this->dummyData->getTaxRate();

        $order = $this->dummyData->getOrder($cartTotal);
        $order->setUser($user);
        $order->setReferenceNumber($referenceNumber);
        $order->setTaxRate($taxRate);

        $orderItem = $this->dummyData->getOrderItem($order, $product, $price);

        $shipment = $this->dummyData->getShipment();
        $shipmentItem = $this->dummyData->getShipmentItem($shipment, $orderItem, 1);

        $order->addShipment($shipment);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);

        $this->orderRepository->create($order);

        $this->entityManager->flush();

        return $order;
    }
}
