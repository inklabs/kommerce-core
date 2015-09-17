<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;

class Attribute extends AbstractService
{
    /** @var AttributeRepositoryInterface */
    private $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function create(Entity\Attribute & $attribute)
    {
        $this->throwValidationErrors($attribute);
        $this->attributeRepository->create($attribute);
    }

    public function edit(Entity\Attribute & $attribute)
    {
        $this->throwValidationErrors($attribute);
        $this->attributeRepository->save($attribute);
    }

    /**
     * @param int $id
     * @return Entity\Attribute|null
     */
    public function find($id)
    {
        return $this->attributeRepository->find($id);
    }
}
