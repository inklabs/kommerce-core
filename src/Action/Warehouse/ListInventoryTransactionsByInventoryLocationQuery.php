<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class ListInventoryTransactionsByInventoryLocationQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $inventoryLocationId;

    /** @var PaginationDTO */
    private $paginationDTO;

    public function __construct(string $inventoryLocationId, PaginationDTO $paginationDTO)
    {
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
        $this->paginationDTO = $paginationDTO;
    }

    public function getInventoryLocationId(): UuidInterface
    {
        return $this->inventoryLocationId;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTO;
    }
}
