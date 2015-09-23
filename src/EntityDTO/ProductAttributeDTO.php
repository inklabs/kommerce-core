<?php
namespace inklabs\kommerce\EntityDTO;

class ProductAttributeDTO
{
    public $id;

    /** @var ProductDTO */
    public $product;

    /** @var AttributeDTO */
    public $attribute;

    /** @var AttributeValueDTO */
    public $attributeValue;
}
