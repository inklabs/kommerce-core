<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\OrderItemDTOBuilder;

interface GetOrderItemResponseInterface
{
    public function setOrderItemDTOBuilder(OrderItemDTOBuilder $orderItemDTOBuilder);
}
