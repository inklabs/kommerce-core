<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\AddShipmentTrackingCodeCommand;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddShipmentTrackingCodeHandlerTest extends ActionTestCase
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
        OptionProduct::class,
        OrderItemOptionProduct::class,
        InventoryTransaction::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $order = $this->dummyData->getOrder();
        $order->setUser($user);
        $product = $this->dummyData->getProduct();
        $orderItem = $this->dummyData->getOrderItem($order, $product);
        $this->persistEntityAndFlushClear([$user, $order, $product]);
        $carrier = $this->dummyData->getShipmentCarrierType();
        $orderItemQtyDTO = new OrderItemQtyDTO();
        $quantityToShip = 2;
        $orderItemQtyDTO->addOrderItemQty(
            $orderItem->getId(),
            $quantityToShip
        );
        $trackingCode = self::SHIPMENT_TRACKING_CODE;
        $comment = self::FAKE_TEXT;
        $command = new AddShipmentTrackingCodeCommand(
            $order->getId()->getHex(),
            $orderItemQtyDTO,
            $comment,
            $carrier->getId(),
            $trackingCode
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $order = $this->getRepositoryFactory()->getOrderRepository()->findOneById(
            $order->getId()
        );
        $shipment = $order->getShipments()[0];
        $this->assertEntitiesEqual($orderItem, $shipment->getShipmentItems()[0]->getOrderItem());
        $this->assertSame($quantityToShip, $shipment->getShipmentItems()[0]->getQuantityToShip());
        $this->assertSame($carrier->getId(), $shipment->getShipmentTrackers()[0]->getCarrier()->getId());
        $this->assertSame($trackingCode, $shipment->getShipmentTrackers()[0]->getTrackingCode());
        $this->assertSame($comment, $shipment->getShipmentComments()[0]->getComment());
    }
}
