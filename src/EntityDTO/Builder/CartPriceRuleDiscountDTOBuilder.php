<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\EntityDTO\CartPriceRuleDiscountDTO;

class CartPriceRuleDiscountDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var CartPriceRuleDiscount */
    protected $entity;

    /** @var CartPriceRuleDiscountDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(
        CartPriceRuleDiscount $cartPriceRuleDiscount,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->entity = $cartPriceRuleDiscount;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new CartPriceRuleDiscountDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->quantity = $this->entity->getQuantity();
    }

    public function withProduct()
    {
        $this->entityDTO->product = $this->dtoBuilderFactory
            ->getProductDTOBuilder($this->entity->getProduct())
            ->withTags()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct();
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
