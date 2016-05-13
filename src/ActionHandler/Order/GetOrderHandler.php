<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderQuery;
use inklabs\kommerce\Service\OrderServiceInterface;

final class GetOrderHandler
{
    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(GetOrderQuery $query)
    {
        $request = $query->getRequest();
        $response = $query->getResponse();

        $order = $this->orderService->findOneById($request->getOrderId());

        $response->setOrderDTO(
            $order->getDTOBuilder()
                ->withAllData()
                ->build()
        );
    }
}
