<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class OptionValue
{
    public $id;
    public $sortOrder;
    public $created;
    public $updated;

    public $name;
    public $sku;
    public $shippingWeight;

    /** @var Product */
    public $product;

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
        unset($this->option);
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
            ->withProduct($pricing);
    }
}
