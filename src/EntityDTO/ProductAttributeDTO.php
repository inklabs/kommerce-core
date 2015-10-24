<?php
namespace inklabs\kommerce\EntityDTO;

class ProductAttributeDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var ProductDTO */
    public $product;

    /** @var AttributeDTO */
    public $attribute;

    /** @var AttributeValueDTO */
    public $attributeValue;
}
