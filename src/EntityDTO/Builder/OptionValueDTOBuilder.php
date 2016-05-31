<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\EntityDTO\OptionValueDTO;

class OptionValueDTOBuilder
{
    /** @var OptionValue */
    protected $optionValue;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(OptionValue $optionValue, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->optionValue = $optionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->optionValueDTO = new OptionValueDTO;
        $this->optionValueDTO->id             = $this->optionValue->getId();
        $this->optionValueDTO->name           = $this->optionValue->getname();
        $this->optionValueDTO->sku            = $this->optionValue->getSku();
        $this->optionValueDTO->shippingWeight = $this->optionValue->getShippingWeight();
        $this->optionValueDTO->sortOrder      = $this->optionValue->getSortOrder();
        $this->optionValueDTO->created        = $this->optionValue->getCreated();
        $this->optionValueDTO->updated        = $this->optionValue->getUpdated();
    }

    public function withOption()
    {
        $this->optionValueDTO->option = $this->dtoBuilderFactory
            ->getOptionDTOBuilder($this->optionValue->getOption())
            ->build();

        return $this;
    }

    public function withPrice()
    {
        $this->optionValueDTO->price = $this->dtoBuilderFactory
            ->getPriceDTOBuilder($this->optionValue->getPrice())
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
