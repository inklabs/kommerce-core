<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\EntityDTO\AttributeValueDTO;

class AttributeValueDTOBuilder
{
    /** @var AttributeValue */
    protected $attributeValue;

    /** @var AttributeValueDTO */
    protected $attributeValueDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(AttributeValue $attributeValue, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->attributeValue = $attributeValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->attributeValueDTO = new AttributeValueDTO;
        $this->attributeValueDTO->id          = $this->attributeValue->getId();
        $this->attributeValueDTO->sku         = $this->attributeValue->getSku();
        $this->attributeValueDTO->name        = $this->attributeValue->getName();
        $this->attributeValueDTO->description = $this->attributeValue->getDescription();
        $this->attributeValueDTO->sortOrder   = $this->attributeValue->getSortOrder();
        $this->attributeValueDTO->created     = $this->attributeValue->getCreated();
        $this->attributeValueDTO->updated     = $this->attributeValue->getUpdated();
    }

    public function withAttribute()
    {
        if ($this->attributeValue->getAttribute() !== null) {
            $this->attributeValueDTO->attribute = $this->dtoBuilderFactory
                ->getAttributeDTOBuilder($this->attributeValue->getAttribute())
                ->build();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->attributeValue->getProductAttributes() as $productAttribute) {
            $this->attributeValueDTO->productAttributes[] = $this->dtoBuilderFactory
                ->getProductAttributeDTOBuilder($productAttribute)
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
