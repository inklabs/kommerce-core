<?php
namespace inklabs\kommerce\ActionResponse\Order;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetOrdersByUserResponse implements ResponseInterface
{
    /** @var OrderDTOBuilder[] */
    private $orderDTOBuilders = [];

    public function addOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder)
    {
        $this->orderDTOBuilders[] = $orderDTOBuilder;
    }

    /**
     * @return OrderDTO[]
     */
    public function getOrderDTOs()
    {
        $orderDTOs = [];
        foreach ($this->orderDTOBuilders as $orderDTOBuilder) {
            $orderDTOs[] = $orderDTOBuilder
                ->build();
        }
        return $orderDTOs;
    }

    /**
     * @return OrderDTO[]
     */
    public function getOrderDTOsWithAllData()
    {
        $orderDTOs = [];
        foreach ($this->orderDTOBuilders as $orderDTOBuilder) {
            $orderDTOs[] = $orderDTOBuilder
                ->withAllData()
                ->build();
        }
        return $orderDTOs;
    }
}
