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
    protected $item;

    /** @var CartPriceRuleProductItemDTO */
    protected $itemDTO;

    public function withProduct()
    {
        $product = $this->item->getProduct();
        if ($product !== null) {
            $this->itemDTO->product = $product->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct();
    }

    protected function getItemDTO()
    {
        return new CartPriceRuleProductItemDTO;
    }
}
