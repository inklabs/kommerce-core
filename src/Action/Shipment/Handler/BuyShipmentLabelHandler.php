<?php
namespace inklabs\kommerce\Action\Shipment\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

class BuyShipmentLabelHandler
{
    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(ShipmentGatewayInterface $shipmentGateway, OrderServiceInterface $orderService)
    {
        $this->shipmentGateway = $shipmentGateway;
        $this->orderService = $orderService;
    }

    public function handle(BuyShipmentLabelCommand $command)
    {
        $shipmentTracker = $this->shipmentGateway->buy(
            $command->getShipmentExternalId(),
            $command->getRateExternalId()
        );

        $shipment = new Shipment;
        $shipment->addShipmentTracker($shipmentTracker);

        $this->orderService->addShipment($command->getOrderId(), $shipment);
    }
}
