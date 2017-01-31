<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class BuyShipmentLabelHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Cart::class,
        Order::class,
        OrderItem::class,
        User::class,
        TaxRate::class,
        Product::class,
        Shipment::class,
        ShipmentComment::class,
        ShipmentItem::class,
        ShipmentTracker::class,
        AbstractPayment::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder();
        $order->setUser($user);
        $product = $this->dummyData->getProduct();
        $orderItem = $this->dummyData->getOrderItem($order, $product);
        $this->persistEntityAndFlushClear([$user, $order, $product]);
        $orderItemQtyDTO = new OrderItemQtyDTO;
        $quantityToShip = 2;
        $orderItemQtyDTO->addOrderItemQty(
            $orderItem->getId(),
            $quantityToShip
        );
        $comment = self::FAKE_TEXT;
        $shipmentExternalId = self::SHIPMENT_RATE_EXTERNAL_ID;
        $rateExternalId = self::RATE_EXTERNAL_ID;
        $command = new BuyShipmentLabelCommand(
            $order->getId()->getHex(),
            $orderItemQtyDTO,
            $comment,
            $shipmentExternalId,
            $rateExternalId
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $order = $this->getRepositoryFactory()->getOrderRepository()->findOneById(
            $order->getId()
        );
        $shipment = $order->getShipments()[0];
        $shipmentItem = $shipment->getShipmentItems()[0];
        $shipmentTracker = $shipment->getShipmentTrackers()[0];
        $this->assertEntitiesEqual($orderItem, $shipmentItem->getOrderItem());
        $this->assertSame($quantityToShip, $shipmentItem->getQuantityToShip());
        $this->assertSame($shipmentExternalId, $shipmentTracker->getShipmentLabel()->getExternalId());
        $this->assertSame($rateExternalId, $shipmentTracker->getShipmentRate()->getExternalId());
        $this->assertSame($comment, $shipment->getShipmentComments()[0]->getComment());
    }
}
