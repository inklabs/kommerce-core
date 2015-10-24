<?php
namespace inklabs\kommerce\EntityDTO;

class CartItemOptionProductDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var OptionProductDTO */
    public $optionProduct;
}
