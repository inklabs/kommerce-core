<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderQuery;
use inklabs\kommerce\ActionResponse\Order\GetOrderResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetOrderHandler implements QueryHandlerInterface
{
    /** @var GetOrderQuery */
    private $query;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetOrderQuery $query,
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->orderRepository = $orderRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->productRepository = $productRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanViewOrder(
            $this->query->getOrderId()
        );
    }

    public function handle()
    {
        $response = new GetOrderResponse();

        $order = $this->orderRepository->findOneById(
            $this->query->getOrderId()
        );

        $products = $order->getProducts();
        $this->productRepository->loadProductTags($products);

        $response->setOrderDTOBuilder(
            $this->dtoBuilderFactory->getOrderDTOBuilder($order)
        );

        return $response;
    }
}
