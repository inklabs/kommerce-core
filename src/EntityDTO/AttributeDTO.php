<?php
namespace inklabs\kommerce\EntityDTO;

class AttributeDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $name;
    public $description;
    public $sortOrder;

    /** @var AttributeValueDTO[] */
    public $attributeValues = [];

    /** @var ProductAttributeDTO[] */
    public $productAttributes = [];
}
