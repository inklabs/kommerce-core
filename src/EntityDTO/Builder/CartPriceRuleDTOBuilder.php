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
    protected $entity;

    /** @var CartPriceRuleDTO */
    protected $entityDTO;

    /**
     * @return AbstractPromotionDTO
     */
    protected function getEntityDTO()
    {
        return new CartPriceRuleDTO;
    }

    public function withCartPriceRuleItems()
    {
        foreach ($this->entity->getCartPriceRuleItems() as $cartPriceRuleItem) {
            $this->entityDTO->cartPriceRuleItems[] = $this->dtoBuilderFactory
                ->getCartPriceRuleItemDTOBuilder($cartPriceRuleItem)
                ->build();
        }

        return $this;
    }

    public function withCartPriceRuleDiscounts()
    {
        foreach ($this->entity->getCartPriceRuleDiscounts() as $cartPriceRuleDiscount) {
            $this->entityDTO->cartPriceRuleDiscounts[] = $this->dtoBuilderFactory
                ->getCartPriceRuleDiscountDTOBuilder($cartPriceRuleDiscount)
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
