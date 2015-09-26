<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\EntityDTO\OrderItemTextOptionValueDTO;

class OrderItemTextOptionValueDTOBuilder
{
    /** @var OrderItemTextOptionValue */
    protected $orderItemTextOptionValue;

    /** @var OrderItemTextOptionValueDTO */
    protected $orderItemTextOptionValueDTO;

    public function __construct(OrderItemTextOptionValue $orderItemTextOptionValue)
    {
        $this->orderItemTextOptionValue = $orderItemTextOptionValue;

        $this->orderItemTextOptionValueDTO = new OrderItemTextOptionValueDTO;
        $this->orderItemTextOptionValueDTO->id              = $this->orderItemTextOptionValue->getId();
        $this->orderItemTextOptionValueDTO->created         = $this->orderItemTextOptionValue->getCreated();
        $this->orderItemTextOptionValueDTO->updated         = $this->orderItemTextOptionValue->getUpdated();
        $this->orderItemTextOptionValueDTO->textOptionName  = $this->orderItemTextOptionValue->getTextOptionName();
        $this->orderItemTextOptionValueDTO->textOptionValue = $this->orderItemTextOptionValue->getTextOptionValue();
    }

    public function withTextOption()
    {
        $this->orderItemTextOptionValueDTO->textOption = $this->orderItemTextOptionValue->getTextOption()
            ->getDTOBuilder()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTextOption();
    }

    public function build()
    {
        return $this->orderItemTextOptionValueDTO;
    }
}
