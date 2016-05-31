<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityDTO\AbstractPromotionDTO;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;

/**
 * @method CartPriceRuleDTO build()
 */
class CartPriceRuleDTOBuilder extends AbstractPromotionDTOBuilder
{
    /** @var CartPriceRule */
    protected $promotion;

    /** @var CartPriceRuleDTO */
    protected $promotionDTO;

    /**
     * @return AbstractPromotionDTO
     */
    protected function getPromotionDTO()
    {
        return new CartPriceRuleDTO;
    }

    public function withCartPriceRuleItems()
    {
        foreach ($this->promotion->getCartPriceRuleItems() as $cartPriceRuleItem) {
            $this->promotionDTO->cartPriceRuleItems[] = $this->dtoBuilderFactory
                ->getCartPriceRuleItemDTOBuilder($cartPriceRuleItem)
                ->build();
        }

        return $this;
    }

    public function withCartPriceRuleDiscounts()
    {
        foreach ($this->promotion->getCartPriceRuleDiscounts() as $cartPriceRuleDiscount) {
            $this->promotionDTO->cartPriceRuleDiscounts[] = $cartPriceRuleDiscount->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCartPriceRuleItems()
            ->withCartPriceRuleDiscounts();
    }
}
