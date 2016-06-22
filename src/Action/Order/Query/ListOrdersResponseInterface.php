<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;

interface ListOrdersResponseInterface
{
    public function setPaginationDTOBuilder(PaginationDTOBuilder$paginationDTOBuilder);
    public function addOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder);
}
