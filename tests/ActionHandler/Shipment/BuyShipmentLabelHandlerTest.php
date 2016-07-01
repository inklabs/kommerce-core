<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\EntityDTO\OrderItemQtyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class BuyShipmentLabelHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('buyShipmentLabel')
            ->once();

        $orderItem = $this->dummyData->getOrderItem();
        $order = $this->dummyData->getOrder(null, [$orderItem]);

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(
            $orderItem->getId(),
            2
        );

        $command = new BuyShipmentLabelCommand(
            $order->getId()->getHex(),
            $orderItemQtyDTO,
            'A comment',
            'shp_xxxxxxx',
            'rate_xxxxxxx'
        );

        $handler = new BuyShipmentLabelHandler($orderService);
        $handler->handle($command);
    }
}
