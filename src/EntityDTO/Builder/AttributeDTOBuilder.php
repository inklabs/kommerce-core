<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityDTO\AttributeDTO;

class AttributeDTOBuilder
{
    /** @var Attribute */
    protected $attribute;

    /** @var AttributeDTO */
    protected $attributeDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Attribute $attribute, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->attribute = $attribute;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->attributeDTO = new AttributeDTO;
        $this->attributeDTO->id          = $this->attribute->getId();
        $this->attributeDTO->name        = $this->attribute->getName();
        $this->attributeDTO->description = $this->attribute->getDescription();
        $this->attributeDTO->sortOrder   = $this->attribute->getSortOrder();
        $this->attributeDTO->created     = $this->attribute->getCreated();
        $this->attributeDTO->updated     = $this->attribute->getUpdated();
    }

    public function withAttributeValues()
    {
        foreach ($this->attribute->getAttributeValues() as $attributeValue) {
            $this->attributeDTO->attributeValues[] = $this->dtoBuilderFactory
                ->getAttributeValueDTOBuilder($attributeValue)
                ->build();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->attribute->getProductAttributes() as $productAttribute) {
            $this->attributeDTO->productAttributes[] = $this->dtoBuilderFactory
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

    public function build()
    {
        return $this->attributeDTO;
    }
}
