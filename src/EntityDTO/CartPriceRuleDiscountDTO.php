<?php
namespace inklabs\kommerce\EntityDTO;

class CartPriceRuleDiscountDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $quantity;

    /** @var ProductDTO */
    public $product;
}
