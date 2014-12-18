<?php
namespace inklabs\kommerce\Entity\View\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;

class Product extends Item
{
    /* @var View\Product */
    public $product;

    public function __construct(Entity\CartPriceRuleItem\Item $item)
    {
        parent::__construct($item);
    }

    public function withProduct()
    {
        $product = $this->item->getProduct();
        if (! empty($product)) {
            $this->product = View\Product::factory($product)
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
