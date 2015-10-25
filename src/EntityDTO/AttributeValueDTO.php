<?php
namespace inklabs\kommerce\EntityDTO;

class AttributeValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $sku;
    public $name;
    public $description;
    public $sortOrder;

    /** @var AttributeDTO */
    public $attribute;

    /** @var ProductAttributeDTO[] */
    public $productAttributes = [];
}
