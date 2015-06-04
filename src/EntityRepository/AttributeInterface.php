<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface AttributeInterface
{
    public function save(Entity\Attribute & $attribute);
    public function create(Entity\Attribute & $attribute);
    public function remove(Entity\Attribute & $attribute);

    /**
     * @param int $id
     * @return Entity\Attribute
     */
    public function find($id);
}
