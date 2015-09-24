<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\EntityDTO\CartPriceRuleProductItemDTO;

class CartPriceRuleProductItemDTOBuilder extends AbstractCartPriceRuleItemDTOBuilder
{
    /** @var CartPriceRuleProductItem */
    protected $cartPriceRuleItem;

    /** @var CartPriceRuleProductItemDTO */
    protected $cartPriceRuleItemDTO;

    public function __construct(CartPriceRuleProductItem $productCartPriceRuleItem)
    {
        $this->cartPriceRuleItemDTO = new CartPriceRuleProductItemDTO;

        parent::__construct($productCartPriceRuleItem);
    }
}
