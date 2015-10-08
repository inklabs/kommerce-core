<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class AttributeValueRepository extends AbstractRepository implements AttributeValueRepositoryInterface
{
    public function getAttributeValuesByIds(array $attributeValueIds, Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $attributeValues = $qb->select('attribute_value')
            ->from('kommerce:AttributeValue', 'attribute_value')
            ->where('attribute_value.id IN (:attributeValueIds)')
            ->setParameter('attributeValueIds', $attributeValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $attributeValues;
    }
}
