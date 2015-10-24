<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemOptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $sku;
    public $optionName;
    public $optionValueName;

    /** @var OptionValueDTO */
    public $optionValue;
}
