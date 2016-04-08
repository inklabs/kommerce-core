<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Action\Shipment\Handler\BuyShipmentLabelHandler;
use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class BuyShipmentLabelHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderService = $this->getMockeryMock(OrderServiceInterface::class);
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

        /** @var OrderServiceInterface $orderService */
        $handler = new BuyShipmentLabelHandler($orderService);
        $handler->handle($command);
    }
}
