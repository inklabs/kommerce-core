<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\GetShipmentTrackerQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ShipmentTrackerRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetShipmentTrackerHandler implements QueryHandlerInterface
{
    /** @var GetShipmentTrackerQuery */
    private $query;

    /** @var ShipmentTrackerRepositoryInterface */
    private $shipmentTrackerRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetShipmentTrackerQuery $query,
        ShipmentTrackerRepositoryInterface $shipmentTrackerRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->shipmentTrackerRepository = $shipmentTrackerRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $shipmentTracker = $this->shipmentTrackerRepository->findOneById(
            $this->query->getRequest()->getShipmentTrackerId()
        );

        $this->query->getResponse()->setShipmentTrackerDTOBuilder(
            $this->dtoBuilderFactory->getShipmentTrackerDTOBuilder($shipmentTracker)
        );
    }
}
