<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface OrderItemOptionProductRepositoryInterface
{
    /**
     * @param int $id
     * @return Entity\OrderItemOptionProduct
     */
    public function find($id);
}
