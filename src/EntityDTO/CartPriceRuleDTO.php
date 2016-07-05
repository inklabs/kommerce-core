<?php
namespace inklabs\kommerce\EntityDTO;

class CartPriceRuleDTO
{
    use IdDTOTrait, TimeDTOTrait, PromotionRedemptionDTOTrait, PromotionStartEndDateDTOTrait;

    /** @var string */
    public $name;

    /** @var int */
    public $reducesTaxSubtotal;

    /** @var CartPriceRuleProductItemDTO|CartPriceRuleTagItemDTO[] */
    public $cartPriceRuleItems = [];

    /** @var CartPriceRuleDiscountDTO[] */
    public $cartPriceRuleDiscounts = [];
}
