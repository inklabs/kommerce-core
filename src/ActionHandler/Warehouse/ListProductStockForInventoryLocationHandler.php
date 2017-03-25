<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\ListProductStockForInventoryLocationQuery;
use inklabs\kommerce\ActionResponse\Warehouse\ListProductStockForInventoryLocationResponse;
use inklabs\kommerce\DTO\ProductStockDTO;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\ProductStock;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListProductStockForInventoryLocationHandler implements QueryHandlerInterface
{
    /** @var ListProductStockForInventoryLocationQuery */
    private $query;

    /** @var InventoryLocationRepositoryInterface */
    private $inventoryLocationRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListProductStockForInventoryLocationQuery $query,
        InventoryLocationRepositoryInterface $inventoryLocationRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->inventoryLocationRepository = $inventoryLocationRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $productStockList = $this->inventoryLocationRepository->listProductStockForInventoryLocation(
            $this->query->getInventoryLocationId(),
            $pagination
        );

        $response = new ListProductStockForInventoryLocationResponse(
            $this->dtoBuilderFactory,
            $pagination,
            $productStockList
        );

        return $response;
    }
}
