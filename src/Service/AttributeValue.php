<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class AttributeValue extends Lib\ServiceManager
{
    /** @var EntityRepository\AttributeValue */
    private $repository;

    public function __construct(EntityRepository\AttributeValueInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View\AttributeValue|null
     */
    public function find($id)
    {
        /** @var Entity\AttributeValue $entityAttributeValue */
        $entityAttributeValue = $this->repository->find($id);

        if ($entityAttributeValue === null) {
            return null;
        }

        return $entityAttributeValue->getView()
            ->withAttribute()
            ->export();
    }

    public function getAttributeValuesByIds($attributeValueIds, Entity\Pagination & $pagination = null)
    {
        $attributeValues = $this->repository
            ->getAttributeValuesByIds($attributeValueIds);

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
