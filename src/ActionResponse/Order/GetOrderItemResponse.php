<?php
namespace inklabs\kommerce\ActionResponse\Order;

use inklabs\kommerce\EntityDTO\Builder\OrderItemDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetOrderItemResponse implements ResponseInterface
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
