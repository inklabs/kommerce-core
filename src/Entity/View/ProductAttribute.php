<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class ProductAttribute
{
    public $id;

    /** @var product */
    public $product;

    /** @var Attribute */
    public $attribute;

    /** @var AttributeValue */
    public $attributeValue;

    public function __construct(Entity\ProductAttribute $productAttribute)
    {
        $this->productAttribute = $productAttribute;

        $this->id = $productAttribute->getId();
    }

    public function export()
    {
        unset($this->productAttribute);
        return $this;
    }

    public function withProduct()
    {
        $this->product = $this->productAttribute->getProduct()->getView();
        return $this;
    }

    public function withAttribute()
    {
        $this->attribute = $this->productAttribute->getAttribute()->getView();
        return $this;
    }

    public function withAttributeValue()
    {
        $this->attributeValue = $this->productAttribute->getAttributeValue()->getView();
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct()
            ->withAttribute()
            ->withAttributeValue();
    }
}
