<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class OrderItem extends AbstractEntityRepository implements OrderItemInterface
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
