<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

/**
 * @method Entity\AttributeValue find($id)
 */
class AttributeValue extends EntityRepository
{
    /**
     * @return Entity\AttributeValue[]
     */
    public function getAttributeValuesByIds($attributeValueIds, Entity\Pagination & $pagination = null)
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
