<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\OrderDTO;

interface GetOrderResponseInterface
{
    public function setOrderDTO(OrderDTO $orderDTO);
}
