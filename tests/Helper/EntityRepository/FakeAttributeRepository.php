<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

class FakeAttributeRepository extends AbstractFakeRepository implements AttributeRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Attribute);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }
}
