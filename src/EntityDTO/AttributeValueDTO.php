<?php
namespace inklabs\kommerce\EntityDTO;

class AttributeValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $sku;

    /** @var string */
    public $name;

    /** @var string */
    public $description;

    /** @var int */
    public $sortOrder;

    /** @var AttributeDTO */
    public $attribute;

    /** @var ProductAttributeDTO[] */
    public $productAttributes = [];
}
