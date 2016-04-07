<?php
namespace inklabs\kommerce\EntityDTO;

class OptionProductDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var string */
    public $sku;

    /** @var int */
    public $shippingWeight;

    /** @var int */
    public $sortOrder;

    /** @var ProductDTO */
    public $product;

    /** @var OptionDTO */
    public $option;
}
