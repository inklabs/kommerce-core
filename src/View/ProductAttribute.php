<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class ProductAttribute implements ViewInterface
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
        if ($this->productAttribute->getProduct() !== null) {
            $this->product = $this->productAttribute->getProduct()->getView();
        }
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
