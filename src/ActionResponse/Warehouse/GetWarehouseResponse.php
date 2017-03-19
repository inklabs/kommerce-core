<?php
namespace inklabs\kommerce\ActionResponse\Warehouse;

use inklabs\kommerce\EntityDTO\Builder\WarehouseDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetWarehouseResponse implements ResponseInterface
{
    /** @var WarehouseDTOBuilder */
    protected $warehouseDTOBuilder;

    public function getWarehouseDTO()
    {
        return $this->warehouseDTOBuilder
            ->build();
    }

    public function setWarehouseDTOBuilder(WarehouseDTOBuilder $warehouseDTOBuilder)
    {
        $this->warehouseDTOBuilder = $warehouseDTOBuilder;
    }
}
