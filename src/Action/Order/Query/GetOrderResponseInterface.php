<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;

interface GetOrderResponseInterface
{
    public function setOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder);
}
