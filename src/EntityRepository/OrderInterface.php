<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderInterface
{
    /**
     * @param int $id
     * @return Entity\Order
     */
    public function find($id);

    /**
     * @param Entity\Order $order
     */
    public function persist(Entity\Order & $order);

    public function flush();

    /**
     * @param Entity\Pagination $pagination
     * @return Entity\Order[]
     */
    public function getLatestOrders(Entity\Pagination & $pagination = null);
}
