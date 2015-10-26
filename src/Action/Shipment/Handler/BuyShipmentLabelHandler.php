<?php
namespace inklabs\kommerce\Action\Shipment\Handler;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

class BuyShipmentLabelHandler
{
    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    public function __construct(ShipmentGatewayInterface $shipmentGateway)
    {
        $this->shipmentGateway = $shipmentGateway;
    }

    public function handle(BuyShipmentLabelCommand $command)
    {
        $shipmentTracker = $this->shipmentGateway->buy(
            $command->getShipmentExternalId(),
            $command->getRateExternalId()
        );

        // TODO: Create Shipment and attach to Order
    }
}
