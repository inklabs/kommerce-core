<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderItemRepositoryInterface
{
    public function save(Entity\OrderItem & $orderItem);
    public function create(Entity\OrderItem & $orderItem);
    public function remove(Entity\OrderItem & $orderItem);
    public function persist(Entity\OrderItem & $orderItem);
    public function flush();

    /**
     * @param int $id
     * @return Entity\OrderItem
     */
    public function find($id);
}
