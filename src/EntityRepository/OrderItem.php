<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class OrderItem extends AbstractEntityRepository implements OrderItemInterface
{
    public function persist(Entity\OrderItem & $orderItem)
    {
        $this->persistEntity($orderItem);
    }

    public function flush()
    {
        $this->flushEntity();
    }
}
