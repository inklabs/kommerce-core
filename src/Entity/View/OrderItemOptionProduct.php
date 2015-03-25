<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class OrderItemOptionProduct
{
    public $id;

    /* @var Option */
    public $option;

    /* @var Product */
    public $product;

    public $optionName;
    public $productSku;
    public $productName;

    public function __construct(Entity\OrderItemOptionProduct $orderOptionProduct)
    {
        $this->id             = $orderOptionProduct->getId();
        $this->optionName     = $orderOptionProduct->getOptionName();
        $this->created        = $orderOptionProduct->getCreated();

        $this->option         = $orderOptionProduct->getOption()->getView()
            ->export();

        $this->product = $orderOptionProduct->getProduct()->getView()
            ->export();

        $this->productName = $orderOptionProduct->getProductName();
        $this->productSku = $orderOptionProduct->getProductSku();
    }
}
