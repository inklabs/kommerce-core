<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\AddShipmentTrackingCodeCommand;
use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddShipmentTrackingCodeHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $carrier = $this->dummyData->getShipmentCarrierType();
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('addShipmentTrackingCode')
            ->once();

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 2);

        $command = new AddShipmentTrackingCodeCommand(
            1,
            $orderItemQtyDTO,
            'A comment',
            $carrier->getId(),
            'xxxxxx'
        );

        $handler = new AddShipmentTrackingCodeHandler($orderService);
        $handler->handle($command);
    }
}
