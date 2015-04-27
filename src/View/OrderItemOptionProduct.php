<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service\Pricing;

class OrderItemOptionProduct implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var OptionProduct */
    public $optionProduct;

    /** @var string */
    public $sku;

    /** @var string */
    public $optionName;

    /** @var string */
    public $optionValueName;

    public function __construct(Entity\OrderItemOptionProduct $orderItemOptionProduct)
    {
        $this->id              = $orderItemOptionProduct->getId();
        $this->created         = $orderItemOptionProduct->getCreated();
        $this->sku             = $orderItemOptionProduct->getSku();
        $this->optionName      = $orderItemOptionProduct->getOptionName();
        $this->optionProductName = $orderItemOptionProduct->getOptionProductName();

        $this->optionProduct = $orderItemOptionProduct->getOptionProduct()->getView()
            ->export();
    }

    public function export()
    {
        return $this;
    }
}
