<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\AttributeInterface;
use inklabs\kommerce\Entity;

class FakeAttribute extends AbstractFake implements AttributeInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Attribute);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }
}
