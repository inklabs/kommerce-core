<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\AttributeInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeAttribute extends Helper\AbstractFake implements AttributeInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Attribute);
    }

    /**
     * @param int $id
     * @return Entity\Attribute
     */
    public function find($id)
    {
        return $this->getReturnValue();
    }
}
