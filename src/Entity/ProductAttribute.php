<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\ProductAttributeDTOBuilder;
use inklabs\kommerce\View;

class ProductAttribute
{
    use Accessor\Time, Accessor\Id;

    /** @var Product */
    protected $product;

    /** @var Attribute */
    protected $attribute;

    /** @var AttributeValue */
    protected $attributeValue;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function getAttributeValue()
    {
        return $this->attributeValue;
    }

    public function setAttributeValue(AttributeValue $attributeValue)
    {
        $this->attributeValue = $attributeValue;
    }

    public function getView()
    {
        return new View\ProductAttribute($this);
    }

    public function getDTOBuilder()
    {
        return new ProductAttributeDTOBuilder($this);
    }
}
