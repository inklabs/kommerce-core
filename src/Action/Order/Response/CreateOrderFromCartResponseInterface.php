<?php
namespace inklabs\kommerce\Action\Order\Response;

use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface CreateOrderFromCartResponseInterface extends ResponseInterface
{
    public function setOrderDTO(OrderDTO $orderDTO);
}
