<?php
namespace inklabs\kommerce\EntityDTO;

class OptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var string */
    public $sku;

    /** @var int */
    public $unitPrice;

    /** @var int */
    public $shippingWeight;

    /** @var int */
    public $sortOrder;

    /** @var OptionDTO */
    public $option;

    /** @var PriceDTO */
    public $price;
}
