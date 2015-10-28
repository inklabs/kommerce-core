<?php
namespace inklabs\kommerce\Action\Shipment\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Service\OrderServiceInterface;

class BuyShipmentLabelHandler
{
    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(BuyShipmentLabelCommand $command)
    {
        $this->orderService->addShipment(
            $command->getOrderId(),
            $command->getOrderItemQtyDTO(),
            $command->getComment(),
            $command->getRateExternalId(),
            $command->getShipmentExternalId()
        );
    }
}
