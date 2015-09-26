<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\EntityDTO\OptionValueDTO;
use inklabs\kommerce\Lib\BaseConvert;

class OptionValueDTOBuilder
{
    /** @var OptionValue */
    protected $optionValue;

    public function __construct(OptionValue $optionValue)
    {
        $this->optionValue = $optionValue;

        $this->optionValueDTO = new OptionValueDTO;
        $this->optionValueDTO->id             = $this->optionValue->getId();
        $this->optionValueDTO->encodedId      = BaseConvert::encode($this->optionValue->getId());
        $this->optionValueDTO->name           = $this->optionValue->getname();
        $this->optionValueDTO->sku            = $this->optionValue->getSku();
        $this->optionValueDTO->shippingWeight = $this->optionValue->getShippingWeight();
        $this->optionValueDTO->sortOrder      = $this->optionValue->getSortOrder();
        $this->optionValueDTO->created        = $this->optionValue->getCreated();
        $this->optionValueDTO->updated        = $this->optionValue->getUpdated();
    }

    public function withOption()
    {
        $this->optionValueDTO->option = $this->optionValue->getOption()->getDTOBuilder()
            ->build();

        return $this;
    }

    public function withPrice()
    {
        $this->optionValueDTO->price = $this->optionValue->getPrice()->getDTOBuilder()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOption()
            ->withPrice();
    }

    public function build()
    {
        return $this->optionValueDTO;
    }
}
