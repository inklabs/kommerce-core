<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;

interface GetOrdersByUserResponseInterface
{
    public function addOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder);
}
