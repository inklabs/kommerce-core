<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\BuyAdHocShipmentLabelCommand;
use inklabs\kommerce\EntityRepository\ShipmentTrackerRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

final class BuyAdHocShipmentLabelHandler implements CommandHandlerInterface
{
    /** @var BuyAdHocShipmentLabelCommand */
    private $command;

    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var ShipmentTrackerRepositoryInterface */
    private $shipmentTrackerRepository;

    public function __construct(
        BuyAdHocShipmentLabelCommand $command,
        ShipmentGatewayInterface $shipmentGateway,
        ShipmentTrackerRepositoryInterface $shipmentTrackerRepository
    ) {
        $this->command = $command;
        $this->shipmentGateway = $shipmentGateway;
        $this->shipmentTrackerRepository = $shipmentTrackerRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $shipmentTracker = $this->shipmentGateway->buy(
            $this->command->getShipmentExternalId(),
            $this->command->getRateExternalId(),
            $this->command->getShipmentTrackerId()
        );

        $this->shipmentTrackerRepository->create($shipmentTracker);
    }
}
