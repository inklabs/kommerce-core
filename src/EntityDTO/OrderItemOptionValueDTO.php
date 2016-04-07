<?php
namespace inklabs\kommerce\EntityDTO;

class OrderItemOptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $sku;

    /** @var string */
    public $optionName;

    /** @var string */
    public $optionValueName;

    /** @var OptionValueDTO */
    public $optionValue;
}
