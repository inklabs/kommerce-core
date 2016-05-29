<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;
use Ramsey\Uuid\UuidInterface;

class AttributeValueRepository extends AbstractRepository implements AttributeValueRepositoryInterface
{
    /**
     * @param UuidInterface[] $attributeValueIds
     * @param Pagination|null $pagination
     * @return AttributeValue[]
     */
    public function getAttributeValuesByIds(array $attributeValueIds, Pagination & $pagination = null)
    {
        $attributeValueBytes = [];
        foreach ($attributeValueIds as $attributeValueId) {
            $attributeValueBytes[] = $attributeValueId->getBytes();
        }

        return $this->getQueryBuilder()
            ->select('AttributeValue')
            ->from(AttributeValue::class, 'AttributeValue')
            ->where('AttributeValue.id IN (:attributeValueIds)')
            ->setParameter('attributeValueIds', $attributeValueBytes)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
