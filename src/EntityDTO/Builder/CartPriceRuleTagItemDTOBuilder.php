<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\EntityDTO\CartPriceRuleTagItemDTO;

/**
 * @method CartPriceRuleTagItemDTO build()
 */
class CartPriceRuleTagItemDTOBuilder extends AbstractCartPriceRuleItemDTOBuilder
{
    /** @var CartPriceRuleTagItem */
    protected $entity;

    /** @var CartPriceRuleTagItemDTO */
    protected $entityDTO;

    /**
     * @return static
     */
    public function withTag()
    {
        $tag = $this->entity->getTag();
        if ($tag !== null) {
            $this->entityDTO->tag = $this->dtoBuilderFactory
                ->getTagDTOBuilder($tag)
                ->build();
        }
        return $this;
    }

    /**
     * @return static
     */
    public function withAllData()
    {
        return $this
            ->withTag();
    }

    protected function getEntityDTO()
    {
        return new CartPriceRuleTagItemDTO;
    }
}
