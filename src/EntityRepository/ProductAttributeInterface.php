<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface ProductAttributeInterface
{
    /**
     * @param int $id
     * @return Entity\ProductAttribute
     */
    public function find($id);
}
