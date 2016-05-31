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
    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        OrderItemTextOptionValue $orderItemTextOptionValue,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->orderItemTextOptionValue = $orderItemTextOptionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->orderItemTextOptionValueDTO = new OrderItemTextOptionValueDTO;
        $this->orderItemTextOptionValueDTO->id              = $this->orderItemTextOptionValue->getId();
        $this->orderItemTextOptionValueDTO->created         = $this->orderItemTextOptionValue->getCreated();
        $this->orderItemTextOptionValueDTO->updated         = $this->orderItemTextOptionValue->getUpdated();
        $this->orderItemTextOptionValueDTO->textOptionName  = $this->orderItemTextOptionValue->getTextOptionName();
        $this->orderItemTextOptionValueDTO->textOptionValue = $this->orderItemTextOptionValue->getTextOptionValue();
    }

    public function withTextOption()
    {
        $this->orderItemTextOptionValueDTO->textOption = $this->dtoBuilderFactory
            ->getTextOptionDTOBuilder($this->orderItemTextOptionValue->getTextOption())
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
