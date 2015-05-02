<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface ProductQuantityDiscountInterface
{
    /**
     * @param int $id
     * @return Entity\ProductQuantityDiscount
     */
    public function find($id);
}
