<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\OrderItemDTOBuilder;

class GetOrderItemResponse implements GetOrderItemResponseInterface
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
