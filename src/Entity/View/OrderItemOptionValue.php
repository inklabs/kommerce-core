<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class OrderItemOptionValue
{
    /** @var int */
    public $id;

    /** @var Option */
    public $option;

    /** @var OptionValue */
    public $optionValue;

    /** @var string */
    public $optionName;

    /** @var string */
    public $sku;

    /** @var string */
    public $name;

    /** @var string */
    public $value;

    public function __construct(Entity\OrderItemOptionValue $orderItemOptionValue)
    {
        $this->id             = $orderItemOptionValue->getId();
        $this->optionName     = $orderItemOptionValue->getName();
        $this->created        = $orderItemOptionValue->getCreated();

        $this->option = $orderItemOptionValue->getOption()->getView()
            ->export();

        $optionValue = $orderItemOptionValue->getOptionValue();
        if ($optionValue !== null) {
            $this->optionValue = $optionValue->getView()
                ->export();
        }

        $this->sku = $orderItemOptionValue->getSku();
        $this->name = $orderItemOptionValue->getName();
        $this->value = $orderItemOptionValue->getValue();
    }
}
