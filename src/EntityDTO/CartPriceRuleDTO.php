<?php
namespace inklabs\kommerce\EntityDTO;

class CartPriceRuleDTO
{
    /** @var CartPriceRuleProductItemDTO|CartPriceRuleTagItemDTO[] */
    public $cartPriceRuleItems = [];

    /** @var CartPriceRuleDiscountDTO[] */
    public $cartPriceRuleDiscounts = [];
}
