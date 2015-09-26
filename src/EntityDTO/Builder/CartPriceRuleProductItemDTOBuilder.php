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
    protected $cartPriceRuleItem;

    /** @var CartPriceRuleProductItemDTO */
    protected $cartPriceRuleItemDTO;

    public function __construct(CartPriceRuleProductItem $productCartPriceRuleItem)
    {
        $this->cartPriceRuleItemDTO = new CartPriceRuleProductItemDTO;

        parent::__construct($productCartPriceRuleItem);
    }

    public function withProduct()
    {
        $product = $this->cartPriceRuleItem->getProduct();
        if ($product !== null) {
            $this->cartPriceRuleItemDTO->product = $product->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct();
    }
}
