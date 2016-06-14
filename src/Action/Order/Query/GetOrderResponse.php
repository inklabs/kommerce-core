<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;

class GetOrderResponse implements GetOrderResponseInterface
{
    /** @var OrderDTOBuilder */
    protected $orderDTOBuilder;

    public function setOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder)
    {
        $this->orderDTOBuilder = $orderDTOBuilder;
    }

    public function getOrderDTO()
    {
        return $this->orderDTOBuilder
            ->build();
    }

    public function getOrderDTOWithAllData()
    {
        return $this->orderDTOBuilder
            ->withAllData()
            ->build();
    }
}
