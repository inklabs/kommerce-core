<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Order extends Lib\ServiceManager
{
    /** @var EntityRepository\Order */
    private $orderRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->orderRepository = $entityManager->getRepository('kommerce:Order');
    }

    /**
     * @return View\Order|null
     */
    public function find($id)
    {
        /** @var Entity\Order $entityOrder */
        $entityOrder = $this->orderRepository->find($id);

        if ($entityOrder === null) {
            return null;
        }

        return $entityOrder->getView()
            ->withAllData()
            ->export();
    }

    public function getLatestOrders(Entity\Pagination & $pagination = null)
    {
        $orders = $this->orderRepository
            ->getLatestOrders($pagination);

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
                ->withAllData()
                ->export();
        }

        return $viewOrders;
    }
}
