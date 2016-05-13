<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\OrderDTO;

class CreateOrderFromCartResponse implements CreateOrderFromCartResponseInterface
{
    /** @var OrderDTO */
    private $orderDTO;

    /**
     * @param OrderDTO $orderDTO
     */
    public function setOrderDTO(OrderDTO $orderDTO)
    {
        $this->orderDTO = $orderDTO;
    }

    public function getOrderDTO()
    {
        return $this->orderDTO;
    }
}
