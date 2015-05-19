<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

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
     * @return View\Order|null
     */
    public function find($id)
    {
        $order = $this->orderRepository->find($id);

        if ($order === null) {
            return null;
        }

        $this->loadProductTags($order);

        return $order->getView()
            ->withAllData()
            ->export();
    }

    private function loadProductTags(Entity\Order $order)
    {
        $products = [];
        foreach ($order->getOrderItems() as $orderItem) {
            $products[] = $orderItem->getProduct();
        }
        $this->productRepository->loadProductTags($products);
    }

    public function getLatestOrders(Entity\Pagination & $pagination = null)
    {
        $orders = $this->orderRepository->getLatestOrders($pagination);
        return $this->getViewOrders($orders);
    }

    /**
     * @param Entity\Order[] $orders
     * @return View\Order[]
     */
    private function getViewOrders($orders)
    {
        $viewOrders = [];
        foreach ($orders as $order) {
            $viewOrders[] = $order->getView()
                ->withUser()
                ->export();
        }

        return $viewOrders;
    }

    /**
     * @param int $userId
     * @return View\Order[]
     */
    public function getOrdersByUserId($userId)
    {
        $orders = $this->orderRepository->getOrdersByUserId($userId);
        return $this->getViewOrders($orders);
    }
}
