<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ListOrdersQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListOrdersHandler implements QueryHandlerInterface
{
    /** @var ListOrdersQuery */
    private $query;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListOrdersQuery $query,
        OrderRepositoryInterface $orderRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->orderRepository = $orderRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $paginationDTO = $this->query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        // TODO: Add query search
        $queryString = $this->query->getRequest()->getQueryString();
        $orders = $this->orderRepository->getLatestOrders($pagination);

        $this->query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($orders as $order) {
            $this->query->getResponse()->addOrderDTOBuilder(
                $this->dtoBuilderFactory->getOrderDTOBuilder($order)
            );
        }
    }
}
