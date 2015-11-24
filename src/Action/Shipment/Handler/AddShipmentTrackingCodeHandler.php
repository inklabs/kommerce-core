<?php
namespace inklabs\kommerce\Action\Shipment\Handler;

use inklabs\kommerce\Action\Shipment\AddShipmentTrackingCodeCommand;
use inklabs\kommerce\Service\OrderServiceInterface;

final class AddShipmentTrackingCodeHandler
{
    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(AddShipmentTrackingCodeCommand $command)
    {
        $this->orderService->addShipmentTrackingCode(
            $command->getOrderId(),
            $command->getOrderItemQtyDTO(),
            $command->getComment(),
            $command->getCarrier(),
            $command->getTrackingCode()
        );
    }
}
