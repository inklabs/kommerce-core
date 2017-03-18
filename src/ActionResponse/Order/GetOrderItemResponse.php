<?php
namespace inklabs\kommerce\ActionResponse\Order;

use inklabs\kommerce\EntityDTO\Builder\OrderItemDTOBuilder;

class GetOrderItemResponse
{
    /** @var OrderItemDTOBuilder */
    protected $orderItemDTOBuilder;

    public function setOrderItemDTOBuilder(OrderItemDTOBuilder $orderItemDTOBuilder)
    {
        $this->orderItemDTOBuilder = $orderItemDTOBuilder;
    }

    public function getOrderItemDTO()
    {
        return $this->orderItemDTOBuilder
            ->build();
    }

    public function getOrderItemDTOWithAllData()
    {
        return $this->orderItemDTOBuilder
            ->withAllData()
            ->build();
    }
}
