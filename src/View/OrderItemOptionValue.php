<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service\Pricing;

class OrderItemOptionValue
{
    /** @var int */
    public $id;

    /** @var OptionValue */
    public $optionValue;

    /** @var string */
    public $sku;

    /** @var string */
    public $optionTypeName;

    /** @var string */
    public $optionValueName;

    public function __construct(Entity\OrderItemOptionValue $orderItemOptionValue)
    {
        $this->id             = $orderItemOptionValue->getId();
        $this->created        = $orderItemOptionValue->getCreated();

        $this->optionValue = $orderItemOptionValue->getOptionValue()->getView()
            ->export();

        $this->sku = $orderItemOptionValue->getSku();
        $this->optionTypeName = $orderItemOptionValue->getOptionTypeName();
        $this->optionValueName = $orderItemOptionValue->getOptionValueName();
    }

    public function export()
    {
        return $this;
    }
}
