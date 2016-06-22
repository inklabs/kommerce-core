<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ListOrdersQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class ListOrdersHandler
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

    public function handle(ListOrdersQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        // TODO: Add query search
        //$query->getRequest()->getQueryString(),
        $orders = $this->orderService->getLatestOrders(
            $pagination
        );

        $query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($orders as $order) {
            $query->getResponse()->addOrderDTOBuilder(
                $this->dtoBuilderFactory->getOrderDTOBuilder($order)
            );
        }
    }
}
