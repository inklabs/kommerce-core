<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;

class Order extends AbstractService
{
    /** @var EntityRepository\OrderInterface */
    private $orderRepository;

    /** @var EntityRepository\ProductInterface */
    private $productRepository;

    public function __construct(
        EntityRepository\OrderInterface $orderRepository,
        EntityRepository\ProductInterface $productRepository
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
