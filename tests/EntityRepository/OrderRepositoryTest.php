<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Cart;
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

    public function setupOrder($referenceNumber = null)
    {
        $uniqueId = crc32($referenceNumber);

        $product = $this->dummyData->getProduct($uniqueId);
        $price = $this->dummyData->getPrice();
        $user = $this->dummyData->getUser($uniqueId);
        $orderItem = $this->dummyData->getOrderItem($product, $price);
        $cartTotal = $this->dummyData->getCartTotal();
        $taxRate = $this->dummyData->getTaxRate();
        $shipment = $this->dummyData->getShipment();
        $shipmentItem = $this->dummyData->getShipmentItem($shipment, $orderItem, 1);

        $order = $this->dummyData->getOrder($cartTotal, [$orderItem]);
        $order->setUser($user);
        $order->setReferenceNumber($referenceNumber);
        $order->setTaxRate($taxRate);
        $order->addShipment($shipment);

        $this->entityManager->persist($product);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);

        $this->orderRepository->create($order);

        $this->entityManager->flush();

        return $order;
    }

    public function testCRUD()
    {
        $order = $this->setupOrder();
        $this->assertSame(1, $order->getId());

        $order->setExternalId('newExternalId');
        $this->assertSame(null, $order->getUpdated());

        $this->orderRepository->update($order);
        $this->assertTrue($order->getUpdated() instanceof DateTime);

        $this->entityManager->clear();
        $order = $this->orderRepository->findOneById($order->getId());
        $this->assertSame('10.0.0.1', $order->getIp4());

        $this->orderRepository->delete($order);
        $this->assertSame(null, $order->getId());
    }

    public function setupOrderForFind($referenceNumber = null)
    {
        $uniqueId = crc32($referenceNumber);

        $product = $this->dummyData->getProduct($uniqueId);
        $product->enableAttachments();

        $catalogPromotion = $this->dummyData->getCatalogPromotion();
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount($product);

        $price = $this->dummyData->getPrice();
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);

        $user = $this->dummyData->getUser($uniqueId);

        $attachmentForOrderItem = $this->dummyData->getAttachment();
        $orderItem = $this->dummyData->getOrderItem($product, $price);
        $orderItem->addAttachment($attachmentForOrderItem);

        $cartTotal = $this->dummyData->getCartTotal();

        $taxRate = $this->dummyData->getTaxRate();

        $shipment = $this->dummyData->getShipment();
        $shipmentItem = $this->dummyData->getShipmentItem($shipment, $orderItem, 1);

        $order = $this->dummyData->getOrder($cartTotal, [$orderItem]);
        $order->setUser($user);
        $order->setReferenceNumber($referenceNumber);
        $order->setTaxRate($taxRate);
        $order->addShipment($shipment);

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->persist($productQuantityDiscount);
        $this->entityManager->persist($product);
        $this->entityManager->persist($attachmentForOrderItem);
        $this->entityManager->persist($user);
        $this->entityManager->persist($taxRate);

        $this->orderRepository->create($order);

        $this->entityManager->flush();

        return $order;
    }

    public function testFindOneById()
    {
        $this->setupOrderForFind();
        $this->entityManager->clear();

        $this->setCountLogger();

        $order = $this->orderRepository->findOneById(1);

        $order->getOrderItems()->toArray();
        $order->getPayments()->toArray();
        $order->getUser()->getCreated();
        $order->getCoupons()->toArray();
        $order->getTaxRate()->getCreated();

        $shipment = $order->getShipments()[0];
        $shipment->getShipmentTrackers()->toArray();
        $shipment->getShipmentItems()[0]->getQuantityToShip();
        $shipment->getShipmentComments()->toArray();

        $this->assertTrue($order instanceof Order);

        $orderItem = $order->getOrderItem(0);
        $orderItem->getProduct()->getCreated();
        $orderItem->getOrder()->getCreated();
        $orderItem->getCatalogPromotions()->toArray();
        $orderItem->getProductQuantityDiscounts()->toArray();
        $orderItem->getOrderItemOptionProducts()->toArray();
        $orderItem->getOrderItemOptionValues()->toArray();
        $orderItem->getOrderItemTextOptionValues()->toArray();

        $this->assertCount(1, $orderItem->getAttachments());

        $this->assertSame(15, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Order not found'
        );

        $this->orderRepository->findOneById(1);
    }

    public function testGetLatestOrders()
    {
        $this->setupOrder();

        $orders = $this->orderRepository->getLatestOrders();

        $this->assertTrue($orders[0] instanceof Order);
    }

    public function testCreateWithSequentialReferenceNumber()
    {
        $this->orderRepository = $this->getRepositoryFactory()->getOrderWithSequentialGenerator();

        $order = $this->setupOrder();

        $this->assertSame(1, $order->getId());
        $this->assertSame('0000000001', $order->getReferenceNumber());
    }

    public function testCreateWithHashReferenceNumber()
    {
        mt_srand(0);

        $this->orderRepository = $this->getRepositoryFactory()->getOrderWithHashSegmentGenerator();

        $order = $this->setupOrder();

        $this->assertSame(1, $order->getId());
        $this->assertSame('963-1273124-1535857', $order->getReferenceNumber());
    }

    public function testCreateWithHashReferenceNumberAndDuplicateFailure()
    {
        mt_srand(0);

        // Simulate 3 duplicates in a row.
        $this->setupOrder('963-1273124-1535857');
        $this->setupOrder('324-1294424-1842424');
        $this->setupOrder('117-1819459-9097917');

        $this->orderRepository->setReferenceNumberGenerator(
            new HashSegmentReferenceNumberGenerator($this->orderRepository)
        );

        $order = $this->setupOrder();

        $this->assertSame(4, $order->getId());
        $this->assertSame(null, $order->getReferenceNumber());
    }

    public function testGetOrdersByUserId()
    {
        $this->setupOrder();

        $orders = $this->orderRepository->getOrdersByUserId(1);

        $this->assertTrue($orders[0] instanceof Order);
        $this->assertSame(1, $orders[0]->getUser()->getId());
    }
}
