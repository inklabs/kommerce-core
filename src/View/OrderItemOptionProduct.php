<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class OrderItemOptionProduct implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var int */
    public $created;

    /** @var int */
    public $updated;

    /** @var string */
    public $sku;

    /** @var string */
    public $optionName;

    /** @var string */
    public $optionProductName;

    /** @var OptionProduct */
    public $optionProduct;

    public function __construct(Entity\OrderItemOptionProduct $orderItemOptionProduct)
    {
        $this->orderItemOptionProduct = $orderItemOptionProduct;

        $this->id                = $orderItemOptionProduct->getId();
        $this->created           = $orderItemOptionProduct->getCreated();
        $this->updated           = $orderItemOptionProduct->getUpdated();
        $this->sku               = $orderItemOptionProduct->getSku();
        $this->optionName        = $orderItemOptionProduct->getOptionName();
        $this->optionProductName = $orderItemOptionProduct->getOptionProductName();
    }

    public function export()
    {
        unset($this->orderItemOptionProduct);
        return $this;
    }

    public function withOptionProduct()
    {
        $this->optionProduct = $this->orderItemOptionProduct->getOptionProduct()->getView()
            ->withOption()
            ->export();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOptionProduct();
    }
}
