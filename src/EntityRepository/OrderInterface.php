<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderInterface
{
    /**
     * @param int $id
     * @method Entity\Order
     */
    public function find($id);

    /**
     * @param Entity\Pagination $pagination
     * @return Entity\Order[]
     */
    public function getLatestOrders(Entity\Pagination & $pagination = null);
}
