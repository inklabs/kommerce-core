<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

class FakeAttributeValueRepository extends AbstractFakeRepository implements AttributeValueRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new AttributeValue);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAttributeValuesByIds(array $attributeValueIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
