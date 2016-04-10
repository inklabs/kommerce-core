<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Action\Shipment\Handler\BuyShipmentLabelHandler;
use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class BuyShipmentLabelHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderService = $this->mockService->getOrderService();
        $orderService->shouldReceive('buyShipmentLabel')
            ->once();

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 2);

        $command = new BuyShipmentLabelCommand(
            1,
            $orderItemQtyDTO,
            'A comment',
            'shp_xxxxxxx',
            'rate_xxxxxxx'
        );

        $handler = new BuyShipmentLabelHandler($orderService);
        $handler->handle($command);
    }
}
