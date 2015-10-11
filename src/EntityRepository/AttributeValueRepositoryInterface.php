<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;

/**
 * @method AttributeValue findOneById($id)
 */
interface AttributeValueRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int[] $attributeValueIds
     * @param Pagination $pagination
     * @return AttributeValue[]
     */
    public function getAttributeValuesByIds(array $attributeValueIds, Pagination & $pagination = null);
}
