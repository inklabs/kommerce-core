<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\AttributeValueInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class FakeAttributeValue extends Helper\AbstractFake implements AttributeValueInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\AttributeValue);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAttributeValuesByIds(array $attributeValueIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
