<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\EntityDTO\OrderItemOptionValueDTO;

class OrderItemOptionValueDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var OrderItemOptionValue */
    protected $entity;

    /** @var OrderItemOptionValueDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(
        OrderItemOptionValue $orderItemOptionValue,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->entity = $orderItemOptionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new OrderItemOptionValueDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->sku             = $this->entity->getSku();
        $this->entityDTO->optionName      = $this->entity->getOptionName();
        $this->entityDTO->optionValueName = $this->entity->getOptionValueName();
    }

    public function withOptionValue()
    {
        $this->entityDTO->optionValue = $this->dtoBuilderFactory
            ->getOptionValueDTOBuilder($this->entity->getOptionValue())
            ->withOption()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOptionValue();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
