<?php
namespace inklabs\kommerce\ActionResponse\Order;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\OrderDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListOrdersResponse implements ResponseInterface
{
    /** @var OrderDTOBuilder[] */
    private $orderDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder): void
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addOrderDTOBuilder(OrderDTOBuilder $orderDTOBuilder): void
    {
        $this->orderDTOBuilders[] = $orderDTOBuilder;
    }

    /**
     * @return OrderDTO[]
     */
    public function getOrderDTOs(): array
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
    public function getOrderWithUserDTOs(): array
    {
        $orderDTOs = [];
        foreach ($this->orderDTOBuilders as $orderDTOBuilder) {
            $orderDTOs[] = $orderDTOBuilder
                ->withUser()
                ->build();
        }
        return $orderDTOs;
    }

    public function getPaginationDTO(): PaginationDTO
    {
        return $this->paginationDTOBuilder->build();
    }
}
