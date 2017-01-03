<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\BuyAdHocShipmentLabelCommand;
use inklabs\kommerce\EntityRepository\ShipmentTrackerRepositoryInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

final class BuyAdHocShipmentLabelHandler
{
    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var ShipmentTrackerRepositoryInterface */
    private $shipmentTrackerRepository;

    public function __construct(
        ShipmentGatewayInterface $shipmentGateway,
        ShipmentTrackerRepositoryInterface $shipmentTrackerRepository
    ) {
        $this->shipmentGateway = $shipmentGateway;
        $this->shipmentTrackerRepository = $shipmentTrackerRepository;
    }

    public function handle(BuyAdHocShipmentLabelCommand $command)
    {
        $shipmentTracker = $this->shipmentGateway->buy(
            $command->getShipmentExternalId(),
            $command->getRateExternalId(),
            $command->getShipmentTrackerId()
        );

        $this->shipmentTrackerRepository->create($shipmentTracker);
    }
}
