<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;

class AttributeValueService
{
    use EntityValidationTrait;

    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    public function __construct(AttributeValueRepositoryInterface $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }

    /**
     * @param int $id
     * @return AttributeValue
     * @throws EntityNotFoundException
     */
    public function findOneById($id)
    {
        return $this->attributeValueRepository->findOneById($id);
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
