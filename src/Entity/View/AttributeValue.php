<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class AttributeValue
{
    public $id;
    public $sku;
    public $name;
    public $description;
    public $sortOrder;

    public function __construct(Entity\AttributeValue $attributeValue)
    {
        $this->id          = $attributeValue->getId();
        $this->sku         = $attributeValue->getSku();
        $this->name        = $attributeValue->getName();
        $this->description = $attributeValue->getDescription();
        $this->sortOrder   = $attributeValue->getSortOrder();
    }
}
