<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\EntityDTO\AttributeValueDTO;
use inklabs\kommerce\Lib\BaseConvert;

class AttributeValueDTOBuilder
{
    /** @var AttributeValue */
    protected $attributeValue;

    /** @var AttributeValueDTO */
    protected $attributeValueDTO;

    public function __construct(AttributeValue $attributeValue)
    {
        $this->attributeValue = $attributeValue;

        $this->attributeValueDTO = new AttributeValueDTO;
        $this->attributeValueDTO->id          = $this->attributeValue->getId();
        $this->attributeValueDTO->encodedId   = BaseConvert::encode($this->attributeValue->getId());
        $this->attributeValueDTO->sku         = $this->attributeValue->getSku();
        $this->attributeValueDTO->name        = $this->attributeValue->getName();
        $this->attributeValueDTO->description = $this->attributeValue->getDescription();
        $this->attributeValueDTO->sortOrder   = $this->attributeValue->getSortOrder();
    }

    public function withAttribute()
    {
        if ($this->attributeValue->getAttribute() !== null) {
            $this->attributeValueDTO->attribute = $this->attributeValue->getAttribute()->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->attributeValue->getProductAttributes() as $productAttribute) {
            $this->attributeValueDTO->productAttributes[] = $productAttribute->getDTOBuilder()
                ->withProduct()
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withAttribute()
            ->withProductAttributes();
    }

    public function build()
    {
        return $this->attributeValueDTO;
    }
}
