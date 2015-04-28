<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Order extends AbstractEntityRepository implements OrderInterface
{
    public function persist(Entity\Order & $order)
    {
        $this->persistEntity($order);
    }

    public function flush()
    {
        $this->flushEntity();
    }

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
