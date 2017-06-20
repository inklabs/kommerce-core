<?php
namespace inklabs\kommerce\ActionResponse\Warehouse;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\WarehouseDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\WarehouseDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListWarehousesResponse implements ResponseInterface
{
    /** @var WarehouseDTOBuilder[] */
    protected $warehouseDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    protected $paginationDTOBuilder;

    public function addWarehouseDTOBuilder(WarehouseDTOBuilder $warehouseDTOBuilder): void
    {
        $this->warehouseDTOBuilders[] = $warehouseDTOBuilder;
    }

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    /**
     * @return WarehouseDTO[]
     */
    public function getWarehouseDTOs(): array
    {
        $warehouseDTOs = [];
        foreach ($this->warehouseDTOBuilders as $warehouseDTOBuilder) {
            $warehouseDTOs[] = $warehouseDTOBuilder->build();
        }
        return $warehouseDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
