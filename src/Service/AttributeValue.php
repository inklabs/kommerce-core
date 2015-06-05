<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

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
     * @return View\AttributeValue|null
     */
    public function find($id)
    {
        /** @var Entity\AttributeValue $entityAttributeValue */
        $entityAttributeValue = $this->attributeValueRepository->find($id);

        if ($entityAttributeValue === null) {
            return null;
        }

        return $entityAttributeValue->getView()
            ->withAttribute()
            ->export();
    }

    public function getAttributeValuesByIds($attributeValueIds, Entity\Pagination & $pagination = null)
    {
        $attributeValues = $this->attributeValueRepository->getAttributeValuesByIds($attributeValueIds, $pagination);
        return $this->getViewAttributeValues($attributeValues);
    }

    /**
     * @param Entity\AttributeValue[] $attributeValues
     * @return View\AttributeValue[]
     */
    private function getViewAttributeValues($attributeValues)
    {
        $viewAttributeValues = [];
        foreach ($attributeValues as $attributeValue) {
            $viewAttributeValues[] = $attributeValue->getView()
                ->withAttribute()
                ->export();
        }

        return $viewAttributeValues;
    }
}
