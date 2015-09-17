<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

class AttributeValue extends AbstractService
{
    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    public function __construct(AttributeValueRepositoryInterface $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    /**
     * @param int $id
     * @return Entity\AttributeValue|null
     */
    public function find($id)
    {
        return $this->attributeValueRepository->find($id);
    }

    /**
     * @param int[] $attributeValueIds
     * @param Entity\Pagination $pagination
     * @return Entity\AttributeValue[]
     */
    public function getAttributeValuesByIds($attributeValueIds, Entity\Pagination & $pagination = null)
    {
        return $this->attributeValueRepository->getAttributeValuesByIds($attributeValueIds, $pagination);
    }
}
