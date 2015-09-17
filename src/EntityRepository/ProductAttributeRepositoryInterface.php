<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface ProductAttributeRepositoryInterface
{
    /**
     * @param int $id
     * @return Entity\ProductAttribute
     */
    public function find($id);
}
