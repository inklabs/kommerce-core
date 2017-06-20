<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\GetInventoryLocationQuery;
use inklabs\kommerce\ActionResponse\Warehouse\GetInventoryLocationResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetInventoryLocationHandler implements QueryHandlerInterface
{
    /** @var GetInventoryLocationQuery */
    private $query;

    /** @var InventoryLocationRepositoryInterface */
    private $inventoryLocationRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetInventoryLocationQuery $query,
        InventoryLocationRepositoryInterface $inventoryLocationRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->inventoryLocationRepository = $inventoryLocationRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new GetInventoryLocationResponse();

        $inventoryLocation = $this->inventoryLocationRepository->findOneById(
            $this->query->getInventoryLocationId()
        );

        $response->setInventoryLocationDTOBuilder(
            $this->dtoBuilderFactory->getInventoryLocationDTOBuilder($inventoryLocation)
        );

        return $response;
    }
}
