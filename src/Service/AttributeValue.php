<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class AttributeValue extends Lib\ServiceManager
{
    /** @var EntityRepository\AttributeValue */
    private $attributeValueRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->attributeValueRepository = $entityManager->getRepository('kommerce:AttributeValue');
    }

    /**
     * @return Entity\View\AttributeValue|null
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
        $attributeValues = $this->attributeValueRepository
            ->getAttributeValuesByIds($attributeValueIds);

        return $this->getViewAttributeValues($attributeValues);
    }

    /**
     * @param Entity\AttributeValue[] $attributeValues
     * @return Entity\View\AttributeValue[]
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
