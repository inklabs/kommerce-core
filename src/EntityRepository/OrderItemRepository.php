<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class OrderItemRepository extends AbstractRepository implements OrderItemRepositoryInterface
{
    public function save(Entity\OrderItem & $orderItem)
    {
        $this->saveEntity($orderItem);
    }

    public function create(Entity\OrderItem & $orderItem)
    {
        $this->createEntity($orderItem);
    }

    public function remove(Entity\OrderItem & $orderItem)
    {
        $this->removeEntity($orderItem);
    }

    public function persist(Entity\OrderItem & $orderItem)
    {
        $this->persistEntity($orderItem);
    }
}
