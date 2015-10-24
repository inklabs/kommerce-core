<?php
namespace inklabs\kommerce\EntityDTO;

class OptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $encodedId;
    public $sortOrder;
    public $name;
    public $sku;
    public $shippingWeight;

    /** @var OptionDTO */
    public $option;

    /** @var PriceDTO */
    public $price;
}
