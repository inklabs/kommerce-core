<?php
namespace inklabs\kommerce\ActionResponse\Order;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetOrderResponse implements ResponseInterface
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
