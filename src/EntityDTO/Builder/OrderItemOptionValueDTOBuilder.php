<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\EntityDTO\OrderItemOptionValueDTO;

class OrderItemOptionValueDTOBuilder
{
    /** @var OrderItemOptionValue */
    protected $orderItemOptionValue;

    /** @var OrderItemOptionValueDTO */
    protected $orderItemOptionValueDTO;

    public function __construct(OrderItemOptionValue $orderItemOptionValue)
    {
        $this->orderItemOptionValue = $orderItemOptionValue;

        $this->orderItemOptionValueDTO = new OrderItemOptionValueDTO;
        $this->orderItemOptionValueDTO->id              = $this->orderItemOptionValue->getId();
        $this->orderItemOptionValueDTO->sku             = $this->orderItemOptionValue->getSku();
        $this->orderItemOptionValueDTO->optionName      = $this->orderItemOptionValue->getOptionName();
        $this->orderItemOptionValueDTO->optionValueName = $this->orderItemOptionValue->getOptionValueName();
        $this->orderItemOptionValueDTO->created         = $this->orderItemOptionValue->getCreated();
        $this->orderItemOptionValueDTO->updated         = $this->orderItemOptionValue->getUpdated();
    }

    public function withOptionValue()
    {
        $this->orderItemOptionValueDTO->optionValue = $this->orderItemOptionValue->getOptionValue()->getDTOBuilder()
            ->withOption()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOptionValue();
    }

    public function build()
    {
        return $this->orderItemOptionValueDTO;
    }
}
