<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

class AttributeService extends AbstractService
{
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
        $this->attributeRepository->save($attribute);
    }

    /**
     * @param int $id
     * @return Attribute|null
     */
    public function find($id)
    {
        return $this->attributeRepository->find($id);
    }
}
