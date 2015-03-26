<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Attribute
{
    public $id;
    public $name;
    public $description;
    public $sortOrder;

    /** @var AttributeValue[] */
    public $attributeValues;

    public function __construct(Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;

        $this->id          = $attribute->getId();
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

    public function withAllData()
    {
        return $this
            ->withAttributeValues();
    }
}
