<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OrderItemOptionProduct;

interface OrderItemOptionProductRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int $id
     * @return OrderItemOptionProduct
     */
    public function find($id);
}
