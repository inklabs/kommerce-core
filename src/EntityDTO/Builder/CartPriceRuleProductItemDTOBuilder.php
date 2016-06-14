<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\EntityDTO\CartPriceRuleProductItemDTO;

/**
 * @method CartPriceRuleProductItemDTO build()
 */
class CartPriceRuleProductItemDTOBuilder extends AbstractCartPriceRuleItemDTOBuilder
{
    /** @var CartPriceRuleProductItem */
    protected $entity;

    /** @var CartPriceRuleProductItemDTO */
    protected $entityDTO;

    public function withProduct()
    {
        $product = $this->entity->getProduct();
        if ($product !== null) {
            $this->entityDTO->product = $this->dtoBuilderFactory
                ->getProductDTOBuilder($product)
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct();
    }

    protected function getEntityDTO()
    {
        return new CartPriceRuleProductItemDTO;
    }
}
