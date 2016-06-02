<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\EntityDTO\OrderItemOptionProductDTO;

class OrderItemOptionProductDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var OrderItemOptionProduct */
    protected $entity;

    /** @var OrderItemOptionProductDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(
        OrderItemOptionProduct $orderItemOptionProduct,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->entity = $orderItemOptionProduct;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new OrderItemOptionProductDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->sku               = $this->entity->getSku();
        $this->entityDTO->optionName        = $this->entity->getOptionName();
        $this->entityDTO->optionProductName = $this->entity->getOptionProductName();
    }

    public function withOptionProduct()
    {
        $this->entityDTO->optionProduct = $this->dtoBuilderFactory
            ->getOptionProductDTOBuilder($this->entity->getOptionProduct())
            ->withOption()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOptionProduct();
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
