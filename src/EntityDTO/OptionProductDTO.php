<?php
namespace inklabs\kommerce\EntityDTO;

class OptionProductDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $name;
    public $sku;
    public $shippingWeight;
    public $sortOrder;

    /** @var ProductDTO */
    public $product;

    /** @var OptionDTO */
    public $option;
}
