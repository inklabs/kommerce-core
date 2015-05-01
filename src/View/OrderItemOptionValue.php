<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service\Pricing;

class OrderItemOptionValue implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var int */
    public $created;

    /** @var int */
    public $updated;

    /** @var OptionValue */
    public $optionValue;

    /** @var string */
    public $sku;

    /** @var string */
    public $optionName;

    /** @var string */
    public $optionValueName;

    public function __construct(Entity\OrderItemOptionValue $orderItemOptionValue)
    {
        $this->orderItemOptionValue = $orderItemOptionValue;

        $this->id              = $orderItemOptionValue->getId();
        $this->created         = $orderItemOptionValue->getCreated();
        $this->updated         = $orderItemOptionValue->getUpdated();
        $this->sku             = $orderItemOptionValue->getSku();
        $this->optionName      = $orderItemOptionValue->getOptionName();
        $this->optionValueName = $orderItemOptionValue->getOptionValueName();
    }

    public function export()
    {
        unset($this->orderItemOptionValue);
        return $this;
    }

    public function withOptionValue()
    {
        $this->optionValue = $this->orderItemOptionValue->getOptionValue()->getView()
            ->withOption()
            ->export();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOptionValue();
    }
}
