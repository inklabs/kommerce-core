<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemTextOptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $textOptionValue;

    /** @var TextOptionDTO */
    public $textOption;
}
