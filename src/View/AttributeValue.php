<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class AttributeValue implements ViewInterface
{
    public $id;
    public $encodedId;
    public $sku;
    public $name;
    public $description;
    public $sortOrder;

    /** @var Attribute */
    public $attribute;

    /** @var ProductAttribute[] */
    public $productAttributes = [];


    public function __construct(Entity\AttributeValue $attributeValue)
    {
        $this->attributeValue = $attributeValue;

        $this->id          = $attributeValue->getId();
        $this->encodedId   = Lib\BaseConvert::encode($attributeValue->getId());
        $this->sku         = $attributeValue->getSku();
        $this->name        = $attributeValue->getName();
        $this->description = $attributeValue->getDescription();
        $this->sortOrder   = $attributeValue->getSortOrder();
    }

    public function export()
    {
        unset($this->attributeValue);
        return $this;
    }

    public function withAttribute()
    {
        if ($this->attributeValue->getAttribute() !== null) {
            $this->attribute = $this->attributeValue->getAttribute()
                ->getView()
                ->export();
        }

        return $this;
    }

    public function withProductAttributes()
    {
        foreach ($this->attributeValue->getProductAttributes() as $productAttribute) {
            $this->productAttributes[] = $productAttribute->getView()
                ->withProduct()
                ->export();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withAttribute()
            ->withProductAttributes();
    }
}
