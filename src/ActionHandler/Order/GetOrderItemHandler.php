<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\GetOrderItemQuery;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetOrderItemHandler implements QueryHandlerInterface
{
    /** @var GetOrderItemQuery */
    private $query;

    /** @var OrderItemRepositoryInterface */
    private $orderItemRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    /** @var null|OrderItem */
    private $orderItem;

    public function __construct(
        GetOrderItemQuery $query,
        OrderItemRepositoryInterface $orderItemRepository,
        ProductRepositoryInterface $productRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->orderItemRepository = $orderItemRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->productRepository = $productRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanViewOrder(
            $this->getOrderItem()->getOrder()->getId()
        );
    }

    public function handle()
    {
        $orderItem = $this->getOrderItem();

        $products = [$orderItem->getProduct()];
        $this->productRepository->loadProductTags($products);

        $this->query->getResponse()->setOrderItemDTOBuilder(
            $this->dtoBuilderFactory->getOrderItemDTOBuilder($orderItem)
        );
    }

    /**
     * @return OrderItem
     */
    private function getOrderItem()
    {
        if ($this->orderItem === null) {
            $this->orderItem = $this->orderItemRepository->findOneById(
                $this->query->getRequest()->getOrderItemId()
            );
        }
        return $this->orderItem;
    }
}
