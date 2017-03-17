<?php
namespace inklabs\kommerce\Action\Warehouse\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\WarehouseDTOBuilder;

interface ListWarehousesResponseInterface
{
    public function addWarehouseDTOBuilder(WarehouseDTOBuilder $warehouseDTOBuilder);
    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder);
}
