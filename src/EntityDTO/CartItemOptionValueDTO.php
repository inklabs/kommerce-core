<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemOptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var OptionValueDTO */
    public $optionValue;
}
