<?php
namespace inklabs\kommerce\EntityDTO;

class AttributeValueDTO
{
    public $id;
    public $encodedId;
    public $sku;
    public $name;
    public $description;
    public $sortOrder;

    /** @var AttributeDTO */
    public $attribute;

    /** @var ProductAttributeDTO[] */
    public $productAttributes = [];
}
