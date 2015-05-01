<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service;

class CartItemOptionProduct implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var int */
    public $created;

    /** @var int */
    public $updated;

    /** @var OptionProduct */
    public $optionProduct;

    public function __construct(Entity\CartItemOptionProduct $cartItemOptionProduct)
    {
        $this->cartItemOptionProduct = $cartItemOptionProduct;

        $this->id      = $cartItemOptionProduct->getId();
        $this->created = $cartItemOptionProduct->getCreated();
        $this->updated = $cartItemOptionProduct->getUpdated();

        $this->optionProduct = $cartItemOptionProduct->getOptionProduct()->getView()->export();
    }

    public function export()
    {
        unset($this->cartItemOptionProduct);
        return $this;
    }

    public function withOptionProduct(Lib\Pricing $pricing)
    {
        $this->optionProduct = $this->cartItemOptionProduct->getOptionProduct()->getView()
            ->withOption()
            ->withProduct($pricing)
            ->export();

        return $this;
    }

    public function withAllData(Lib\Pricing $pricing)
    {
        return $this
            ->withOptionProduct($pricing);
    }
}
