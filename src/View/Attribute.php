<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Attribute
{
    public $id;
    public $encodedId;
    public $name;
    public $description;
    public $sortOrder;

    /** @var AttributeValue[] */
    public $attributeValues = [];

    /** @var ProductAttribute[] */
    public $productAttributes = [];

    public function __construct(Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;

        $this->id          = $attribute->getId();
        $this->encodedId   = Lib\BaseConvert::encode($attribute->getId());
        $this->name        = $attribute->getName();
        $this->description = $attribute->getDescription();
        $this->sortOrder   = $attribute->getSortOrder();
    }

    public function export()
    {
        unset($this->attribute);
        return $this;
    }

    public function withAttributeValues()
    {
        foreach ($this->attribute->getAttributeValues() as $attributeValue) {
            $this->attributeValues[] = $attributeValue->getView();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->attribute->getProductAttributes() as $productAttribute) {
            $this->productAttributes[] = $productAttribute->getView();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withAttributeValues()
            ->withProductAttributes();
    }
}
