<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrdersByUserQuery;
use inklabs\kommerce\ActionResponse\Order\GetOrdersByUserResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetOrdersByUserHandler implements QueryHandlerInterface
{
    /** @var GetOrdersByUserQuery */
    private $query;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetOrdersByUserQuery $query,
        OrderRepositoryInterface $orderRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->orderRepository = $orderRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageUser(
            $this->query->getUserId()
        );
    }

    public function handle()
    {
        $response = new GetOrdersByUserResponse();

        $orders = $this->orderRepository->getOrdersByUserId(
            $this->query->getUserId()
        );

        foreach ($orders as $order) {
            $response->addOrderDTOBuilder(
                $this->dtoBuilderFactory->getOrderDTOBuilder($order)
            );
        }

        return $response;
    }
}
