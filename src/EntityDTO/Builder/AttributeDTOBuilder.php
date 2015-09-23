<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\EntityDTO\AttributeDTO;
use inklabs\kommerce\Lib\BaseConvert;

class AttributeDTOBuilder
{
    /** @var Attribute */
    protected $attribute;

    /** @var AttributeDTO */
    protected $attributeDTO;

    public function __construct(Attribute $attribute)
    {
        $this->attribute = $attribute;

        $this->attributeDTO = new AttributeDTO;
        $this->attributeDTO->id          = $this->attribute->getId();
        $this->attributeDTO->encodedId   = BaseConvert::encode($this->attribute->getId());
        $this->attributeDTO->name        = $this->attribute->getName();
        $this->attributeDTO->description = $this->attribute->getDescription();
        $this->attributeDTO->sortOrder   = $this->attribute->getSortOrder();
    }

    public function withAttributeValues()
    {
        foreach ($this->attribute->getAttributeValues() as $attributeValue) {
            $this->attributeDTO->attributeValues[] = $attributeValue->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->attribute->getProductAttributes() as $productAttribute) {
            $this->attributeDTO->productAttributes[] = $productAttribute->getDTOBuilder()
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
