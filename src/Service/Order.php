<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

class Order extends AbstractService
{
    /** @var OrderRepositoryInterface */
    private $orderRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $id
     * @return Entity\Order|null
     */
    public function find($id)
    {
        $order = $this->orderRepository->find($id);
        $this->loadProductTags($order);
        return $order;
    }

    private function loadProductTags(Entity\Order $order)
    {
        $products = $order->getProducts();
        $this->productRepository->loadProductTags($products);
    }

    public function getLatestOrders(Entity\Pagination & $pagination = null)
    {
        return $this->orderRepository->getLatestOrders($pagination);
    }

    /**
     * @param int $userId
     * @return Entity\Order[]
     */
    public function getOrdersByUserId($userId)
    {
        return $this->orderRepository->getOrdersByUserId($userId);
    }
}
