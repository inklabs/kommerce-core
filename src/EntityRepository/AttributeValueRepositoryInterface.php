<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

interface AttributeValueRepositoryInterface
{
    /**
     * @param int $id
     * @return Entity\AttributeValue
     */
    public function find($id);

    /**
     * @param int[] $attributeValueIds
     * @param Entity\Pagination $pagination
     * @return Entity\AttributeValue[]
     */
    public function getAttributeValuesByIds(array $attributeValueIds, Entity\Pagination & $pagination = null);
}
