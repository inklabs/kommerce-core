<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;

class CreateOrderFromCartResponse implements CreateOrderFromCartResponseInterface
{
    /** @var OrderDTOBuilder */
    private $orderDTOBuilder;

    public function setOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder)
    {
        $this->orderDTOBuilder = $orderDTOBuilder;
    }

    public function getOrderDTO()
    {
        return $this->orderDTOBuilder->build();
    }
}
