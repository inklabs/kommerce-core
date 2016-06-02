<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\EntityDTO\OrderItemTextOptionValueDTO;

class OrderItemTextOptionValueDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var OrderItemTextOptionValue */
    protected $entity;

    /** @var OrderItemTextOptionValueDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(
        OrderItemTextOptionValue $orderItemTextOptionValue,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->entity = $orderItemTextOptionValue;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new OrderItemTextOptionValueDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->textOptionName  = $this->entity->getTextOptionName();
        $this->entityDTO->textOptionValue = $this->entity->getTextOptionValue();
    }

    public function withTextOption()
    {
        $this->entityDTO->textOption = $this->dtoBuilderFactory
            ->getTextOptionDTOBuilder($this->entity->getTextOption())
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withTextOption();
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
