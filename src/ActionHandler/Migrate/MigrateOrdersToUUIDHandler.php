<?php
namespace inklabs\kommerce\ActionHandler\Migrate;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\Action\Migrate\MigrateOrdersToUUIDCommand;
use inklabs\kommerce\Entity\Order;

class MigrateOrdersToUUIDHandler
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(MigrateOrdersToUUIDCommand $command)
    {
        $orders = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from(Order::class, 'o')
            ->getQuery()
            ->iterate();

        foreach ($orders as $row) {
            /** @var Order $order */
            $order = $row[0];

            $order->setUuid();
            $this->migrateOrderItems($order);

            $this->entityManager->flush();
        }
    }

    private function migrateOrderItems(Order $order)
    {
        foreach ($order->getOrderItems() as $orderItem) {
            $orderItem->setUuid();
            $orderItem->setOrderUuid($order->getUuid());
        }
    }
}
