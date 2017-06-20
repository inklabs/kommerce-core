<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\GetWarehouseQuery;
use inklabs\kommerce\ActionResponse\Warehouse\GetWarehouseResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetWarehouseHandler implements QueryHandlerInterface
{
    /** @var GetWarehouseQuery */
    private $query;

    /** @var WarehouseRepositoryInterface */
    private $warehouseRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetWarehouseQuery $query,
        WarehouseRepositoryInterface $warehouseRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->warehouseRepository = $warehouseRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new GetWarehouseResponse();

        $warehouse = $this->warehouseRepository->findOneById(
            $this->query->getWarehouseId()
        );

        $response->setWarehouseDTOBuilder(
            $this->dtoBuilderFactory->getWarehouseDTOBuilder($warehouse)
        );

        return $response;
    }
}
