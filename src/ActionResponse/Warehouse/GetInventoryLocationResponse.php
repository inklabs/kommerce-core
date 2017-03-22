<?php
namespace inklabs\kommerce\ActionResponse\Warehouse;

use inklabs\kommerce\EntityDTO\Builder\InventoryLocationDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetInventoryLocationResponse implements ResponseInterface
{
    /** @var InventoryLocationDTOBuilder */
    protected $inventoryLocationDTOBuilder;

    public function getInventoryLocationDTO()
    {
        return $this->inventoryLocationDTOBuilder
            ->build();
    }

    public function getInventoryLocationDTOWithAllData()
    {
        return $this->inventoryLocationDTOBuilder
            ->withAllData()
            ->build();
    }

    public function setInventoryLocationDTOBuilder(InventoryLocationDTOBuilder $inventoryLocationDTOBuilder)
    {
        $this->inventoryLocationDTOBuilder = $inventoryLocationDTOBuilder;
    }
}
