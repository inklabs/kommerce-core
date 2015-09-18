<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeAttributeValueRepository extends AbstractFakeRepository implements AttributeValueRepositoryInterface
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
