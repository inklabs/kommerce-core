<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Shipment\AddShipmentTrackingCodeCommand;
use inklabs\kommerce\Action\Shipment\Handler\AddShipmentTrackingCodeHandler;
use inklabs\kommerce\Action\Shipment\OrderItemQtyDTO;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddShipmentTrackingCodeHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $orderService = $this->getMockeryMock(OrderServiceInterface::class);
        $orderService->shouldReceive('addShipmentTrackingCode')
            ->once();
        /** @var OrderServiceInterface $orderService */

        $orderItemQtyDTO = new OrderItemQtyDTO;
        $orderItemQtyDTO->addOrderItemQty(1, 2);

        $command = new AddShipmentTrackingCodeCommand(
            1,
            $orderItemQtyDTO,
            'A comment',
            ShipmentTracker::CARRIER_USPS,
            'xxxxxx'
        );

        $handler = new AddShipmentTrackingCodeHandler($orderService);
        $handler->handle($command);
    }
}
