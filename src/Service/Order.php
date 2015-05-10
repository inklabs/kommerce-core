<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class Order extends AbstractService
{
    /** @var EntityRepository\OrderInterface */
    private $orderRepository;

    public function __construct(EntityRepository\OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
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

        return $order->getView()
            ->withAllData()
            ->export();
    }

    public function getLatestOrders(Entity\Pagination & $pagination = null)
    {
        $orders = $this->orderRepository->getLatestOrders($pagination);
        return $this->getSimpleViewOrders($orders);
    }

    /**
     * @param Entity\Order[] $orders
     * @return View\Order[]
     */
    private function getSimpleViewOrders($orders)
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
     * @param Entity\Order[] $orders
     * @return View\Order[]
     */
    private function getViewOrders($orders)
    {
        $viewOrders = [];
        foreach ($orders as $order) {
            $viewOrders[] = $order->getView()
                ->withAllData()
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
        return $this->getSimpleViewOrders($orders);
    }
}
