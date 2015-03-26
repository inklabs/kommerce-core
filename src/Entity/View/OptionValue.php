<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

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

    /** @var Product */
    public $product;

    /** @var Option */
    public $option;

    public function __construct(Entity\OptionValue $optionValue)
    {
        $this->optionValue = $optionValue;

        $this->id          = $optionValue->getId();
        $this->encodedId   = Lib\BaseConvert::encode($optionValue->getId());
        $this->sortOrder   = $optionValue->getSortOrder();
        $this->created     = $optionValue->getCreated();
        $this->updated     = $optionValue->getUpdated();
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

    public function withProduct(Pricing $pricing)
    {
        $this->product = $this->optionValue->getProduct()->getView()
            ->withAllData($pricing)
            ->export();

        $this->sku = $this->optionValue->getSku();
        $this->name = $this->optionValue->getName();
        $this->shippingWeight = $this->optionValue->getShippingWeight();

        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withOption()
            ->withProduct($pricing);
    }
}
