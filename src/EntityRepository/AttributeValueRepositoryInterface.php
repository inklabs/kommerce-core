<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;
use Ramsey\Uuid\UuidInterface;

/**
 * @method AttributeValue findOneById(UuidInterface $id)
 */
interface AttributeValueRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface[] $attributeValueIds
     * @param Pagination $pagination
     * @return AttributeValue[]
     */
    public function getAttributeValuesByIds(array $attributeValueIds, Pagination & $pagination = null);
}
