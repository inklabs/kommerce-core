<?php
namespace inklabs\kommerce\Action\Order\Handler;

use inklabs\kommerce\Action\Order\GetOrderRequest;
use inklabs\kommerce\Action\Order\Response\GetOrderResponseInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

class GetOrderHandler
{
    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(GetOrderRequest $request, GetOrderResponseInterface & $response)
    {
        $order = $this->orderService->findOneById($request->getOrderId());

        $response->setOrderDTO(
            $order->getDTOBuilder()
                ->withAllData()
                ->build()
        );
    }
}
