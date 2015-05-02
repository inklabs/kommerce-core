<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;
use inklabs\kommerce\Lib;

class OptionValue
{
    /** @var int */
    public $id;

    /** @var int */
    public $encodedId;

    /** @var int */
    public $sortOrder;

    /** @var int */
    public $created;

    /** @var int */
    public $updated;

    /** @var string */
    public $name;

    /** @var string */
    public $sku;

    /** @var int */
    public $shippingWeight;

    /** @var Option */
    public $option;

    /** @var Price */
    public $price;

    public function __construct(Entity\OptionValue $optionValue)
    {
        $this->optionValue = $optionValue;

        $this->id             = $optionValue->getId();
        $this->encodedId      = Lib\BaseConvert::encode($optionValue->getId());
        $this->name           = $optionValue->getname();
        $this->sku            = $optionValue->getSku();
        $this->shippingWeight = $optionValue->getShippingWeight();
        $this->sortOrder      = $optionValue->getSortOrder();
        $this->created        = $optionValue->getCreated();
        $this->updated        = $optionValue->getUpdated();
    }

    public function export()
    {
        unset($this->optionValue);
        return $this;
    }

    public function withOption()
    {
        $this->option = $this->optionValue->getOption()->getView()
            ->export();

        return $this;
    }

    public function withPrice()
    {
        $this->price = $this->optionValue->getPrice()->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOption()
            ->withPrice();
    }
}
