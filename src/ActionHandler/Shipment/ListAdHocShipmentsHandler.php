<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\ListAdHocShipmentsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ShipmentTrackerRepositoryInterface;

final class ListAdHocShipmentsHandler
{
    /** @var ShipmentTrackerRepositoryInterface */
    private $shipmentTrackerRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ShipmentTrackerRepositoryInterface $shipmentTrackerRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->shipmentTrackerRepository = $shipmentTrackerRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListAdHocShipmentsQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $paginationDTO = $request->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $shipmentTrackers = $this->shipmentTrackerRepository->getAllAdHocShipments(
            $request->getQueryString(),
            $pagination
        );

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($shipmentTrackers as $shipmentTracker) {
            $response->addShipmentTrackerDTOBuilder(
                $this->dtoBuilderFactory->getShipmentTrackerDTOBuilder($shipmentTracker)
            );
        }
    }
}
