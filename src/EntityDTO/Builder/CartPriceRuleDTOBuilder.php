<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;

class CartPriceRuleDTOBuilder
{
    use IdDTOBuilderTrait,
        TimeDTOBuilderTrait,
        PromotionStartEndDateDTOBuilderTrait,
        PromotionRedemptionDTOBuilderTrait;

    /** @var CartPriceRule */
    protected $entity;

    /** @var CartPriceRuleDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(CartPriceRule $cartPriceRule, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $cartPriceRule;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->setStartEndDate();
        $this->setRedemption();
        $this->entityDTO->name = $this->entity->getName();
        $this->entityDTO->reducesTaxSubtotal = $this->entity->getReducesTaxSubtotal();
        $this->entityDTO->isRedemptionCountValid = $this->entity->isRedemptionCountValid();
    }

    /**
     * @return CartPriceRuleDTO
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

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
