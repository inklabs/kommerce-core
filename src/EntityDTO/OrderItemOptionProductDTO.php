<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemOptionProductDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $sku;

    /** @var string */
    public $optionName;

    /** @var string */
    public $optionProductName;

    /** @var OptionProductDTO */
    public $optionProduct;
}
