<?php
namespace inklabs\kommerce\EntityDTO;

class CartPriceRuleDTO extends AbstractPromotionDTO
{
    /** @var CartPriceRuleProductItemDTO|CartPriceRuleTagItemDTO[] */
    public $cartPriceRuleItems = [];

    /** @var CartPriceRuleDiscountDTO[] */
    public $cartPriceRuleDiscounts = [];
}
