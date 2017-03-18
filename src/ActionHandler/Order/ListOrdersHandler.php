<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\ListOrdersQuery;
use inklabs\kommerce\ActionResponse\Order\ListOrdersResponse;
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
        $response = new ListOrdersResponse();

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        // TODO: Add query search
        $queryString = $this->query->getQueryString();
        $orders = $this->orderRepository->getLatestOrders($pagination);

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($orders as $order) {
            $response->addOrderDTOBuilder(
                $this->dtoBuilderFactory->getOrderDTOBuilder($order)
            );
        }

        return $response;
    }
}
