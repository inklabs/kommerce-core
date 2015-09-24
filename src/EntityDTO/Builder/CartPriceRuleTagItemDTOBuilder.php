<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\EntityDTO\CartPriceRuleTagItemDTO;

class CartPriceRuleTagItemDTOBuilder extends AbstractCartPriceRuleItemDTOBuilder
{
    /** @var CartPriceRuleTagItem */
    protected $cartPriceRuleItem;

    /** @var CartPriceRuleTagItemDTO */
    protected $cartPriceRuleItemDTO;

    public function __construct(CartPriceRuleTagItem $productCartPriceRuleItem)
    {
        $this->cartPriceRuleItemDTO = new CartPriceRuleTagItemDTO;

        parent::__construct($productCartPriceRuleItem);
    }
}
