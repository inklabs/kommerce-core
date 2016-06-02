<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityDTO\AttributeDTO;

class AttributeDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Attribute */
    protected $entity;

    /** @var AttributeDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Attribute $attribute, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $attribute;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new AttributeDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->name        = $this->entity->getName();
        $this->entityDTO->description = $this->entity->getDescription();
        $this->entityDTO->sortOrder   = $this->entity->getSortOrder();
    }

    public function withAttributeValues()
    {
        foreach ($this->entity->getAttributeValues() as $attributeValue) {
            $this->entityDTO->attributeValues[] = $this->dtoBuilderFactory
                ->getAttributeValueDTOBuilder($attributeValue)
                ->build();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->entity->getProductAttributes() as $productAttribute) {
            $this->entityDTO->productAttributes[] = $this->dtoBuilderFactory
                ->getProductAttributeDTOBuilder($productAttribute)
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withAttributeValues()
            ->withProductAttributes();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        return $this->entityDTO;
    }
}
