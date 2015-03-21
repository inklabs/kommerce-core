<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

/**
 * @method Entity\Order find($id)
 */
class Order extends EntityRepository
{
    /**
     * @return Entity\Order[]
     */
    public function getLatestOrders(Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $orders = $qb->select('o')
            ->from('kommerce:Order', 'o')
            ->paginate($pagination)
            ->orderBy('o.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $orders;
    }
}
