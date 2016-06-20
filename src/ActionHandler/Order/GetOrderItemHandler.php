<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderItemQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class GetOrderItemHandler
{
    /** @var OrderServiceInterface */
    private $orderService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(OrderServiceInterface $orderService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->orderService = $orderService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(GetOrderItemQuery $query)
    {
        $orderItem = $this->orderService->getOrderItemById(
            $query->getRequest()->getOrderItemId()
        );

        $query->getResponse()->setOrderItemDTOBuilder(
            $this->dtoBuilderFactory->getOrderItemDTOBuilder($orderItem)
        );
    }
}
