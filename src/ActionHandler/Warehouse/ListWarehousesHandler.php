<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\ListWarehousesQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListWarehousesHandler implements QueryHandlerInterface
{
    /** @var ListWarehousesQuery */
    private $query;

    /** @var WarehouseRepositoryInterface */
    private $warehouseRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListWarehousesQuery $query,
        WarehouseRepositoryInterface $warehouseRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->warehouseRepository = $warehouseRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $request = $this->query->getRequest();
        $response = $this->query->getResponse();

        $paginationDTO = $request->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $warehouses = $this->warehouseRepository->getAllWarehouses(
            $request->getQueryString(),
            $pagination
        );

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($warehouses as $warehouse) {
            $response->addWarehouseDTOBuilder(
                $this->dtoBuilderFactory->getWarehouseDTOBuilder($warehouse)
            );
        }
    }
}
