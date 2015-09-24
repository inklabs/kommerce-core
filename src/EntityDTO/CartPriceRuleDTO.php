<?php
namespace inklabs\kommerce\EntityDTO;

class CartPriceRuleDTO
{
    /** @var CartPriceRuleAbstractItemDTO[] */
    public $cartPriceRuleItems = [];

    /** @var CartPriceRuleDiscountDTO[] */
    public $cartPriceRuleDiscounts = [];
}
