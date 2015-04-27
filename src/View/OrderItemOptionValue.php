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
        $this->id              = $orderItemOptionValue->getId();
        $this->created         = $orderItemOptionValue->getCreated();
        $this->updated         = $orderItemOptionValue->getUpdated();
        $this->sku             = $orderItemOptionValue->getSku();
        $this->optionName      = $orderItemOptionValue->getOptionName();
        $this->optionValueName = $orderItemOptionValue->getOptionValueName();

        $this->optionValue = $orderItemOptionValue->getOptionValue()->getView()
            ->export();
    }

    public function export()
    {
        return $this;
    }
}
