<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;

class AttributeValue extends AbstractService
{
    /** @var EntityRepository\AttributeValue */
    private $attributeValueRepository;

    public function __construct(EntityRepository\AttributeValueInterface $attributeValueRepository)
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

    public function getAttributeValuesByIds($attributeValueIds, Entity\Pagination & $pagination = null)
    {
        return $this->attributeValueRepository->getAttributeValuesByIds($attributeValueIds, $pagination);
    }
}
