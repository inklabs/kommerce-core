<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service\Pricing;

class CartItemOptionProduct implements ViewInterface
{
    public $id;

    /** @var Option */
    public $option;

    /** @var Product */
    public $product;

    public function __construct(Entity\CartItemOptionProduct $cartOptionProduct)
    {
        $this->cartOptionProduct = $cartOptionProduct;

        $this->id             = $cartOptionProduct->getId();
        $this->option         = $cartOptionProduct->getOption()->getView()->export();
        $this->created        = $cartOptionProduct->getCreated();
    }

    public function export()
    {
        unset($this->cartOptionProduct);
        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $this->product = $this->cartOptionProduct->getProduct()->getView()
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->export();

        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withProduct($pricing);
    }
}
