<?php
namespace inklabs\kommerce\Action\Order\Response;

use inklabs\kommerce\EntityDTO\OrderDTO;

final class GetOrderResponse implements GetOrderResponseInterface
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
