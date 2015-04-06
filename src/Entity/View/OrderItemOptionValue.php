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
    public $optionValueName;

    public function __construct(Entity\OrderItemOptionValue $orderItemOptionValue)
    {
        $this->id             = $orderItemOptionValue->getId();
        $this->optionName     = $orderItemOptionValue->getOptionName();
        $this->created        = $orderItemOptionValue->getCreated();

        $this->optionValue    = $orderItemOptionValue->getOptionValue()->getView()
            ->export();

        $this->optionValueName = $orderItemOptionValue->getOptionValueName();
        $this->sku = $orderItemOptionValue->getSku();
    }
}
