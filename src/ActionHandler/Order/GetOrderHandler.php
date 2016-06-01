<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class GetOrderHandler
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

    public function handle(GetOrderQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $order = $this->orderService->findOneById(
            $request->getOrderId()
        );

        $response->setOrderDTOBuilder(
            $this->dtoBuilderFactory->getOrderDTOBuilder($order)
        );
    }
}
