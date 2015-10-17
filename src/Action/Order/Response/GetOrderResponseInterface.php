<?php
namespace inklabs\kommerce\Action\Order\Response;

use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface GetOrderResponseInterface extends ResponseInterface
{
    public function setOrderDTO(OrderDTO $orderDTO);
}
