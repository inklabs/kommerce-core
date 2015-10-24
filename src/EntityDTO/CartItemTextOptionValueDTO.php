<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemTextOptionValueDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $textOptionValue;

    /** @var TextOptionDTO */
    public $textOption;
}
