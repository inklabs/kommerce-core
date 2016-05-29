<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;

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
     * @param UuidInterface $id
     * @return AttributeValue
     * @throws EntityNotFoundException
     */
    public function findOneById(UuidInterface $id)
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
