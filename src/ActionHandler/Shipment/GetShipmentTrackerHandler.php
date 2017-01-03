<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentTrackerQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ShipmentTrackerRepositoryInterface;

final class GetShipmentTrackerHandler
{
    /** @var ShipmentTrackerRepositoryInterface */
    private $shipmentTrackerRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ShipmentTrackerRepositoryInterface $shipmentTrackerRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->shipmentTrackerRepository = $shipmentTrackerRepository;
    }

    public function handle(GetShipmentTrackerQuery $query)
    {
        $shipmentTracker = $this->shipmentTrackerRepository->findOneById(
            $query->getRequest()->getShipmentTrackerId()
        );

        $query->getResponse()->setShipmentTrackerDTOBuilder(
            $this->dtoBuilderFactory->getShipmentTrackerDTOBuilder($shipmentTracker)
        );
    }
}
