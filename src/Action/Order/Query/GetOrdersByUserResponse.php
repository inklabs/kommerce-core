<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\EntityDTO\OrderDTO;

class GetOrdersByUserResponse implements GetOrdersByUserResponseInterface
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
