<?php
namespace inklabs\kommerce\ActionResponse\Order;

use inklabs\kommerce\EntityDTO\Builder\OrderItemDTOBuilder;
use inklabs\kommerce\EntityDTO\OrderItemDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetOrderItemResponse implements ResponseInterface
{
    /** @var OrderItemDTOBuilder */
    protected $orderItemDTOBuilder;

    public function setOrderItemDTOBuilder(OrderItemDTOBuilder $orderItemDTOBuilder): void
    {
        $this->orderItemDTOBuilder = $orderItemDTOBuilder;
    }

    public function getOrderItemDTO(): OrderItemDTO
    {
        return $this->orderItemDTOBuilder
            ->build();
    }

    public function getOrderItemDTOWithAllData(): OrderItemDTO
    {
        return $this->orderItemDTOBuilder
            ->withAllData()
            ->build();
    }
}
