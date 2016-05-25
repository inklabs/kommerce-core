<?php
namespace inklabs\kommerce\ActionHandler\Migrate;

use Doctrine\ORM\EntityManagerInterface;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TempUuidTrait;

class MigrateToUUIDHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle()
    {
        $this->migrateTags();
        $this->migrateCatalogPromotions();
        $this->migrateOrders();
    }

    private function migrateTags()
    {
        $entityQuery = $this->getEntityQuery(Tag::class);
        $this->setUUIDAndFlush($entityQuery);
    }

    private function migrateCatalogPromotions()
    {
        $entityQuery = $this->getEntityQuery(CatalogPromotion::class);
        $this->setUUIDAndFlush($entityQuery);

        foreach ($this->iterate($entityQuery) as $catalogPromotion) {
            /** @var CatalogPromotion $catalogPromotion */
            $tag = $catalogPromotion->getTag();

            if ($tag !== null) {
                $catalogPromotion->setTagUuid($tag->getUuid());
            }
        }
        $this->entityManager->flush();
    }

    private function migrateOrders()
    {
        $entityQuery = $this->getEntityQuery(Order::class);
        $this->setUUIDAndFlush($entityQuery);

        foreach ($this->iterate($entityQuery) as $order) {
            $this->migrateOrderItems($order);
        }

        $this->entityManager->flush();
    }

    private function migrateOrderItems(Order $order)
    {
        foreach ($order->getOrderItems() as $orderItem) {
            $orderItem->setUuid();
            $orderItem->setOrderUuid($order->getUuid());
        }
    }

    /**
     * @param $entityClass
     * @return \Doctrine\ORM\Query
     */
    private function getEntityQuery($entityClass)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('table')
            ->from($entityClass, 'table')
            ->getQuery();
    }

    /**
     * @param $entityQuery
     */
    private function setUUIDAndFlush(\Doctrine\ORM\Query $entityQuery)
    {
        foreach ($this->iterate($entityQuery) as $entity) {
            $entity->setUuid();
        }

        $this->entityManager->flush();
    }

    /**
     * @param \Doctrine\ORM\Query $entityQuery
     * @return \Generator | TempUuidTrait[]
     */
    private function iterate(\Doctrine\ORM\Query $entityQuery)
    {
        foreach ($entityQuery->iterate() as $row) {
            yield $row[0];
        }
    }
}
