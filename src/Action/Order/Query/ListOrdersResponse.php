<?php
namespace inklabs\kommerce\Action\Order\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\OrderDTO;

class ListOrdersResponse implements ListOrdersResponseInterface
{
    /** @var OrderDTOBuilder[] */
    private $orderDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

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
            $orderDTOs[] = $orderDTOBuilder->build();
        }
        return $orderDTOs;
    }

    /**
     * @return OrderDTO[]
     */
    public function getOrderWithUserDTOs()
    {
        $orderDTOs = [];
        foreach ($this->orderDTOBuilders as $orderDTOBuilder) {
            $orderDTOs[] = $orderDTOBuilder
                ->withUser()
                ->build();
        }
        return $orderDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
