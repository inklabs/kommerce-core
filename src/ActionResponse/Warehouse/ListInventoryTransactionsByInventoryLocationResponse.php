<?php
namespace inklabs\kommerce\ActionResponse\Warehouse;

use inklabs\kommerce\EntityDTO\Builder\InventoryTransactionDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\InventoryTransactionDTO;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListInventoryTransactionsByInventoryLocationResponse implements ResponseInterface
{
    /** @var InventoryTransactionDTOBuilder[] */
    protected $inventoryTransactionDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addInventoryTransactionDTOBuilder(
        InventoryTransactionDTOBuilder $inventoryTransactionDTOBuilder
    ): void {
        $this->inventoryTransactionDTOBuilders[] = $inventoryTransactionDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return InventoryTransactionDTO[]
     */
    public function getInventoryTransactionDTOs(): array
    {
        $inventoryTransactionDTOs = [];
        foreach ($this->inventoryTransactionDTOBuilders as $inventoryTransactionDTOBuilder) {
            $inventoryTransactionDTOs[] = $inventoryTransactionDTOBuilder
                ->withProduct()
                ->build();
        }
        return $inventoryTransactionDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
