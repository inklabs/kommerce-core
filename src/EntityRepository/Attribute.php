<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Attribute extends AbstractEntityRepository implements AttributeInterface
{
    public function save(Entity\Attribute & $attribute)
    {
        $this->saveEntity($attribute);
    }

    public function create(Entity\Attribute & $attribute)
    {
        $this->createEntity($attribute);
    }

    public function remove(Entity\Attribute & $attribute)
    {
        $this->removeEntity($attribute);
    }
}
