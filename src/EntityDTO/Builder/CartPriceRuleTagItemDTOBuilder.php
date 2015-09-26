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
    protected $cartPriceRuleItem;

    /** @var CartPriceRuleTagItemDTO */
    protected $cartPriceRuleItemDTO;

    public function __construct(CartPriceRuleTagItem $productCartPriceRuleItem)
    {
        $this->cartPriceRuleItemDTO = new CartPriceRuleTagItemDTO;

        parent::__construct($productCartPriceRuleItem);
    }

    public function withTag()
    {
        $tag = $this->cartPriceRuleItem->getTag();
        if ($tag !== null) {
            $this->cartPriceRuleItemDTO->tag = $tag->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTag();
    }
}
