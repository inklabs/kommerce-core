<?php
namespace inklabs\kommerce\ActionResponse\Warehouse;

use inklabs\kommerce\EntityDTO\Builder\InventoryLocationDTOBuilder;
use inklabs\kommerce\EntityDTO\InventoryLocationDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetInventoryLocationResponse implements ResponseInterface
{
    /** @var InventoryLocationDTOBuilder */
    protected $inventoryLocationDTOBuilder;

    public function setInventoryLocationDTOBuilder(InventoryLocationDTOBuilder $inventoryLocationDTOBuilder): void
    {
        $this->inventoryLocationDTOBuilder = $inventoryLocationDTOBuilder;
    }

    public function getInventoryLocationDTO(): InventoryLocationDTO
    {
        return $this->inventoryLocationDTOBuilder
            ->build();
    }

    public function getInventoryLocationDTOWithAllData(): InventoryLocationDTO
    {
        return $this->inventoryLocationDTOBuilder
            ->withAllData()
            ->build();
    }
}
