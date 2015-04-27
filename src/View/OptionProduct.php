<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Lib;
use inklabs\kommerce\Entity;

class OptionProduct implements ViewInterface
{
    /** @var int */
    public $id;

    /** @var string */
    public $encodedId;

    /** @var string */
    public $name;

    /** @var string */
    public $sku;

    /** @var int */
    public $shippingWeight;

    /** @var int */
    public $sortOrder;

    /** @var Product */
    public $product;

    /** @var Option */
    public $option;

    public $created;
    public $updated;

    public function __construct(Entity\OptionProduct $optionProduct)
    {
        $this->optionValue = $optionProduct;

        $this->id             = $optionProduct->getId();
        $this->encodedId      = Lib\BaseConvert::encode($optionProduct->getId());
        $this->name           = $optionProduct->getname();
        $this->sku            = $optionProduct->getSku();
        $this->shippingWeight = $optionProduct->getShippingWeight();
        $this->sortOrder      = $optionProduct->getSortOrder();
        $this->created        = $optionProduct->getCreated();
        $this->updated        = $optionProduct->getUpdated();

        $this->product = $optionProduct->getProduct()->getView()->export();
    }

    public function export()
    {
        unset($this->optionValue);
        return $this;
    }

    public function withOption()
    {
        $option = $this->optionValue->getOption();
        if ($option !== null) {
            $this->option = $option->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOption();
    }
}
