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
    protected $item;

    /** @var CartPriceRuleTagItemDTO */
    protected $itemDTO;

    public function withTag()
    {
        $tag = $this->item->getTag();
        if ($tag !== null) {
            $this->itemDTO->tag = $tag->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTag();
    }

    protected function getItemDTO()
    {
        return new CartPriceRuleTagItemDTO;
    }
}
