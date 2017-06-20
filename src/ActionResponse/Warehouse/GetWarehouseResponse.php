<?php
namespace inklabs\kommerce\ActionResponse\Warehouse;

use inklabs\kommerce\EntityDTO\Builder\WarehouseDTOBuilder;
use inklabs\kommerce\EntityDTO\WarehouseDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetWarehouseResponse implements ResponseInterface
{
    /** @var WarehouseDTOBuilder */
    protected $warehouseDTOBuilder;

    public function setWarehouseDTOBuilder(WarehouseDTOBuilder $warehouseDTOBuilder): void
    {
        $this->warehouseDTOBuilder = $warehouseDTOBuilder;
    }

    public function getWarehouseDTO(): WarehouseDTO
    {
        return $this->warehouseDTOBuilder
            ->build();
    }

    public function getWarehouseDTOWithAllData(): WarehouseDTO
    {
        return $this->warehouseDTOBuilder
            ->withAllData()
            ->build();
    }
}
