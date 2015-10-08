<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItem;

interface OrderItemRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int $id
     * @return OrderItem
     */
    public function find($id);
}
