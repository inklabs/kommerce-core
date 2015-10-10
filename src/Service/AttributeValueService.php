<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;

class AttributeValueService extends AbstractService
{
    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    public function __construct(AttributeValueRepositoryInterface $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    /**
     * @param int $id
     * @return AttributeValue|null
     */
    public function find($id)
    {
        return $this->attributeValueRepository->find($id);
    }

    /**
     * @param int[] $attributeValueIds
     * @param Pagination $pagination
     * @return AttributeValue[]
     */
    public function getAttributeValuesByIds($attributeValueIds, Pagination & $pagination = null)
    {
        return $this->attributeValueRepository->getAttributeValuesByIds($attributeValueIds, $pagination);
    }
}
