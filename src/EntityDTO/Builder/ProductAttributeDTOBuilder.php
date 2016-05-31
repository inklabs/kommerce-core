<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\EntityDTO\ProductAttributeDTO;

class ProductAttributeDTOBuilder
{
    /** @var ProductAttribute */
    protected $productAttributeDTO;

    /** @var ProductAttribute */
    protected $productAttribute;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(ProductAttribute $productAttribute, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->productAttribute = $productAttribute;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->productAttributeDTO = new ProductAttributeDTO;
        $this->productAttributeDTO->id      = $this->productAttribute->getId();
        $this->productAttributeDTO->created = $this->productAttribute->getCreated();
        $this->productAttributeDTO->updated = $this->productAttribute->getUpdated();
    }

    public function withProduct()
    {
        $product = $this->productAttribute->getProduct();
        if ($product !== null) {
            $this->productAttributeDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($product)
                ->build();
        }

        return $this;
    }

    public function withAttribute()
    {
        $this->productAttributeDTO->attribute = $this->dtoBuilderFactory
            ->getAttributeDTOBuilder($this->productAttribute->getAttribute())
            ->build();

        return $this;
    }

    public function withAttributeValue()
    {
        $this->productAttributeDTO->attributeValue = $this->dtoBuilderFactory
            ->getAttributeValueDTOBuilder($this->productAttribute->getAttributeValue())
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct()
            ->withAttribute()
            ->withAttributeValue();
    }

    public function build()
    {
        return $this->productAttributeDTO;
    }
}
