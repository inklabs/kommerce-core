<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemOptionProductDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $sku;
    public $optionName;
    public $optionProductName;

    /** @var OptionProductDTO */
    public $optionProduct;
}
