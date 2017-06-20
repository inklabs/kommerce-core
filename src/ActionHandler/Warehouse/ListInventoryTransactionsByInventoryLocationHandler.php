<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\ListInventoryTransactionsByInventoryLocationQuery;
use inklabs\kommerce\ActionResponse\Warehouse\ListInventoryTransactionsByInventoryLocationResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\InventoryTransactionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListInventoryTransactionsByInventoryLocationHandler implements QueryHandlerInterface
{
    /** @var ListInventoryTransactionsByInventoryLocationQuery */
    private $query;

    /** @var InventoryTransactionRepositoryInterface */
    private $inventoryTransactionRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListInventoryTransactionsByInventoryLocationQuery $query,
        InventoryTransactionRepositoryInterface $inventoryTransactionRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->inventoryTransactionRepository = $inventoryTransactionRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new ListInventoryTransactionsByInventoryLocationResponse();

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $inventoryTransactions = $this->inventoryTransactionRepository->listByInventoryLocation(
            $this->query->getInventoryLocationId(),
            $pagination
        );

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($inventoryTransactions as $inventoryTransaction) {
            $response->addInventoryTransactionDTOBuilder(
                $this->dtoBuilderFactory->getInventoryTransactionDTOBuilder($inventoryTransaction)
            );
        }

        return $response;
    }
}
