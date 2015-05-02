<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderItemInterface
{
    /**
     * @param int $id
     * @return Entity\OrderItem
     */
    public function find($id);

    /**
     * @param Entity\OrderItem $orderItem
     */
    public function create(Entity\OrderItem & $orderItem);

    /**
     * @param Entity\OrderItem $orderItem
     */
    public function save(Entity\OrderItem & $orderItem);

    /**
     * @param Entity\OrderItem $orderItem
     */
    public function persist(Entity\OrderItem & $orderItem);

    public function flush();
}
