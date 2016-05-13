<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\OrderDTO;

class GetOrderResponse implements GetOrderResponseInterface
{
    /** @var OrderDTO */
    protected $orderDTO;

    public function setOrderDTO(OrderDTO $orderDTO)
    {
        $this->orderDTO = $orderDTO;
    }

    public function getOrderDTO()
    {
        return $this->orderDTO;
    }
}
