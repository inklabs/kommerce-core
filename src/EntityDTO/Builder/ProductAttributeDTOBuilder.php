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

    public function __construct(ProductAttribute $productAttribute)
    {
        $this->productAttribute = $productAttribute;

        $this->productAttributeDTO = new ProductAttributeDTO;
        $this->productAttributeDTO->id = $this->productAttribute->getId();
    }

    public function withProduct()
    {
        $product = $this->productAttribute->getProduct();
        if ($product !== null) {
            $this->productAttributeDTO->product = $product->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withAttribute()
    {
        $this->productAttributeDTO->attribute = $this->productAttribute->getAttribute()->getDTOBuilder()
            ->build();

        return $this;
    }

    public function withAttributeValue()
    {
        $this->productAttributeDTO->attributeValue = $this->productAttribute->getAttributeValue()->getDTOBuilder()
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
