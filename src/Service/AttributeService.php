<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;

class AttributeService
{
    use EntityValidationTrait;

    /** @var AttributeRepositoryInterface */
    private $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function create(Attribute & $attribute)
    {
        $this->throwValidationErrors($attribute);
        $this->attributeRepository->create($attribute);
    }

    public function edit(Attribute & $attribute)
    {
        $this->throwValidationErrors($attribute);
        $this->attributeRepository->update($attribute);
    }

    /**
     * @param int $id
     * @return Attribute
     * @throws \inklabs\kommerce\Exception\EntityNotFoundException
     */
    public function findOneById($id)
    {
        return $this->attributeRepository->findOneById($id);
    }
}
