<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\AddShipmentTrackingCodeCommand;
use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddShipmentTrackingCodeHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $carrier = $this->dummyData->getShipmentCarrierType();
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('addShipmentTrackingCode')
            ->once();

        $orderItem = $this->dummyData->getOrderItem();
        $order = $this->dummyData->getOrder(null, [$orderItem]);

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(
            $orderItem->getId(),
            2
        );

        $command = new AddShipmentTrackingCodeCommand(
            $order->getId()->getHex(),
            $orderItemQtyDTO,
            'A comment',
            $carrier->getId(),
            'xxxxxx'
        );

        $handler = new AddShipmentTrackingCodeHandler($orderService);
        $handler->handle($command);
    }
}
