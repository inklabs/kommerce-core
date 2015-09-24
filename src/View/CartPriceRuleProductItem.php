<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;

class CartPriceRuleProductItem extends AbstractCartPriceRuleItem
{
    /** @var View\Product */
    public $product;

    public function __construct(Entity\AbstractCartPriceRuleItem $item)
    {
        parent::__construct($item);
    }

    public function withProduct()
    {
        $product = $this->item->getProduct();
        if (! empty($product)) {
            $this->product = $product->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withProduct()
            ->export();
    }
}
