<?php
namespace inklabs\kommerce\ActionResponse\Order;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetOrderResponse implements ResponseInterface
{
    /** @var OrderDTOBuilder */
    protected $orderDTOBuilder;

    public function setOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder): void
    {
        $this->orderDTOBuilder = $orderDTOBuilder;
    }

    public function getOrderDTO(): OrderDTO
    {
        return $this->orderDTOBuilder
            ->build();
    }

    public function getOrderDTOWithAllData(): OrderDTO
    {
        return $this->orderDTOBuilder
            ->withAllData()
            ->build();
    }
}
