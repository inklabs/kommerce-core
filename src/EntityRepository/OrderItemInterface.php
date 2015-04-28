<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderItemInterface
{
    /**
     * @param Entity\OrderItem $orderItem
     */
    public function persist(Entity\OrderItem & $orderItem);

    public function flush();
}
