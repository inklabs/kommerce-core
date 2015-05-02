<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface AttributeInterface
{
    /**
     * @param int $id
     * @return Entity\Attribute
     */
    public function find($id);
}
