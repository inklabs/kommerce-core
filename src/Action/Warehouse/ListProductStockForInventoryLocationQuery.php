<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class ListProductStockForInventoryLocationQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $inventoryLocationId;

    /** @var PaginationDTO */
    private $paginationDTO;

    /**
     * @param string $inventoryLocationId
     * @param PaginationDTO $paginationDTO
     */
    public function __construct($inventoryLocationId, PaginationDTO $paginationDTO)
    {
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
        $this->paginationDTO = $paginationDTO;
    }

    public function getInventoryLocationId()
    {
        return $this->inventoryLocationId;
    }

    public function getPaginationDTO()
    {
        return $this->paginationDTO;
    }
}
