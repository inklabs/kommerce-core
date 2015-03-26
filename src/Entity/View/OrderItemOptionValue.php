<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class OrderItemOptionValue
{
    /** @var int */
    public $id;

    /** @var OptionValue */
    public $optionValue;

    /** @var string */
    public $optionName;

    /** @var string */
    public $sku;

    /** @var string */
    public $name;

    public function __construct(Entity\OrderItemOptionValue $orderOptionProduct)
    {
        $this->id             = $orderOptionProduct->getId();
        $this->optionName     = $orderOptionProduct->getOptionName();
        $this->created        = $orderOptionProduct->getCreated();

        $this->optionValue    = $orderOptionProduct->getOptionValue()->getView()
            ->export();

        $this->name = $orderOptionProduct->getName();
        $this->sku = $orderOptionProduct->getSku();
    }
}
