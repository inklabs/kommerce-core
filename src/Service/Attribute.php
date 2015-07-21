<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;

class Attribute extends AbstractService
{
    /** @var EntityRepository\Attribute */
    private $attributeRepository;

    public function __construct(EntityRepository\AttributeInterface $attributeRepository)
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
