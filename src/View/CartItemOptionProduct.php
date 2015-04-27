<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service\Pricing;

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
        $this->id      = $cartItemOptionProduct->getId();
        $this->created = $cartItemOptionProduct->getCreated();
        $this->updated = $cartItemOptionProduct->getUpdated();

        $this->optionProduct = $cartItemOptionProduct->getOptionProduct()->getView()->export();
    }

    public function export()
    {
        return $this;
    }
}
