<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrdersByUserQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class GetOrdersByUserHandler
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

    public function handle(GetOrdersByUserQuery $query)
    {
        $orders = $this->orderService->getOrdersByUserId(
            $query->getRequest()->getUserId()
        );

        foreach ($orders as $order) {
            $query->getResponse()->addOrderDTOBuilder(
                $this->dtoBuilderFactory->getOrderDTOBuilder($order)
            );
        }
    }
}
