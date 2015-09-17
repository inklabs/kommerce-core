<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeAttributeRepository extends AbstractFakeRepository implements AttributeRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Attribute);
    }

    public function save(Entity\Attribute & $attribute)
    {
    }

    public function create(Entity\Attribute & $attribute)
    {
    }

    public function remove(Entity\Attribute & $attribute)
    {
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }
}
