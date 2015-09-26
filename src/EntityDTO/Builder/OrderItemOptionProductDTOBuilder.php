<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\EntityDTO\OrderItemOptionProductDTO;

class OrderItemOptionProductDTOBuilder
{
    /** @var OrderItemOptionProduct */
    protected $orderItemOptionProduct;

    /** @var OrderItemOptionProductDTO */
    protected $orderItemOptionProductDTO;

    public function __construct(OrderItemOptionProduct $orderItemOptionProduct)
    {
        $this->orderItemOptionProduct = $orderItemOptionProduct;

        $this->orderItemOptionProductDTO = new OrderItemOptionProductDTO;
        $this->orderItemOptionProductDTO->id                = $this->orderItemOptionProduct->getId();
        $this->orderItemOptionProductDTO->created           = $this->orderItemOptionProduct->getCreated();
        $this->orderItemOptionProductDTO->updated           = $this->orderItemOptionProduct->getUpdated();
        $this->orderItemOptionProductDTO->sku               = $this->orderItemOptionProduct->getSku();
        $this->orderItemOptionProductDTO->optionName        = $this->orderItemOptionProduct->getOptionName();
        $this->orderItemOptionProductDTO->optionProductName = $this->orderItemOptionProduct->getOptionProductName();
    }

    public function withOptionProduct()
    {
        $this->orderItemOptionProductDTO->optionProduct = $this->orderItemOptionProduct->getOptionProduct()
            ->getDTOBuilder()
            ->withOption()
            ->build();

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOptionProduct();
    }

    public function build()
    {
        return $this->orderItemOptionProductDTO;
    }
}
