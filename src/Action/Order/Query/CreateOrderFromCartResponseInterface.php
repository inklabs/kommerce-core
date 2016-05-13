<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\OrderDTO;

interface CreateOrderFromCartResponseInterface
{
    public function setOrderDTO(OrderDTO $orderDTO);
}
