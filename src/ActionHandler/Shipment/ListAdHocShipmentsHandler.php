<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\ListAdHocShipmentsQuery;
use inklabs\kommerce\ActionResponse\Shipment\ListAdHocShipmentsResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ShipmentTrackerRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListAdHocShipmentsHandler implements QueryHandlerInterface
{
    /** @var ListAdHocShipmentsQuery */
    private $query;

    /** @var ShipmentTrackerRepositoryInterface */
    private $shipmentTrackerRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListAdHocShipmentsQuery $query,
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
        $response = new ListAdHocShipmentsResponse();

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $shipmentTrackers = $this->shipmentTrackerRepository->getAllAdHocShipments(
            $this->query->getQueryString(),
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

        return $response;
    }
}
