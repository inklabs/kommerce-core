<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;

class AttributeValueRepository extends AbstractRepository implements AttributeValueRepositoryInterface
{
    public function getAttributeValuesByIds(array $attributeValueIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('AttributeValue')
            ->from(AttributeValue::class, 'AttributeValue')
            ->where('AttributeValue.id IN (:attributeValueIds)')
            ->setParameter('attributeValueIds', $attributeValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
