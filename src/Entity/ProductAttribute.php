<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ProductAttributeDTOBuilder;

class ProductAttribute
{
    use TimeTrait, IdTrait;

    /** @var Product */
    protected $product;

    /** @var Attribute */
    protected $attribute;

    /** @var AttributeValue */
    protected $attributeValue;

    public function __construct(Product $product, Attribute $attribute, AttributeValue $attributeValue)
    {
        $this->setCreated();
        $this->product = $product;
        $this->attribute = $attribute;
        $this->attributeValue = $attributeValue;

        $product->addProductAttribute($this);
        $attribute->addProductAttribute($this);
        $attributeValue->addProductAttribute($this);
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    public function getDTOBuilder()
    {
        return new ProductAttributeDTOBuilder($this);
    }
}
