<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderItemOptionProductInterface
{
    /**
     * @param int $id
     * @return Entity\OrderItemOptionProduct
     */
    public function find($id);
}
