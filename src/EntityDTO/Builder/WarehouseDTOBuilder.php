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

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Warehouse $warehouse, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->warehouse = $warehouse;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->warehouseDTO = new WarehouseDTO;
        $this->warehouseDTO->id      = $this->warehouse->getId();
        $this->warehouseDTO->name    = $this->warehouse->getName();
        $this->warehouseDTO->created = $this->warehouse->getCreated();
        $this->warehouseDTO->updated = $this->warehouse->getUpdated();

        $this->warehouseDTO->address = $this->dtoBuilderFactory
            ->getAddressDTOBuilder($this->warehouse->getAddress())
            ->build();
    }

    public function build()
    {
        return $this->warehouseDTO;
    }
}
