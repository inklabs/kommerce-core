<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\WarehouseDTO;

class WarehouseDTOBuilder
{
    /** @var Warehouse */
    protected $warehouse;

    /** @var WarehouseDTO */
    protected $warehouseDTO;

    public function __construct(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;

        $this->warehouseDTO = new WarehouseDTO;
        $this->warehouseDTO->id      = $this->warehouse->getId();
        $this->warehouseDTO->name    = $this->warehouse->getName();
        $this->warehouseDTO->address = $this->warehouse->getAddress()->getDTOBuilder()->build();
        $this->warehouseDTO->created = $this->warehouse->getCreated();
        $this->warehouseDTO->updated = $this->warehouse->getUpdated();
    }

    public function build()
    {
        return $this->warehouseDTO;
    }
}
