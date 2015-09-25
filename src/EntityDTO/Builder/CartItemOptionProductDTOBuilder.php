<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\EntityDTO\CartItemOptionProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class CartItemOptionProductDTOBuilder
{
    public function __construct(CartItemOptionProduct $cartItemOptionProduct)
    {
        $this->cartItemOptionProduct = $cartItemOptionProduct;

        $this->cartItemOptionProductDTO = new CartItemOptionProductDTO;
        $this->cartItemOptionProductDTO->id      = $this->cartItemOptionProduct->getId();
        $this->cartItemOptionProductDTO->created = $this->cartItemOptionProduct->getCreated();
        $this->cartItemOptionProductDTO->updated = $this->cartItemOptionProduct->getUpdated();

        $this->cartItemOptionProductDTO->optionProduct = $this->cartItemOptionProduct->getOptionProduct()
            ->getDTOBuilder()
            ->build();
    }

    public function withOptionProduct(PricingInterface $pricing)
    {
        $this->cartItemOptionProductDTO->optionProduct = $this->cartItemOptionProduct->getOptionProduct()
            ->getDTOBuilder()
            ->withOption()
            ->withProduct($pricing)
            ->build();

        return $this;
    }

    public function withAllData(PricingInterface $pricing)
    {
        return $this
            ->withOptionProduct($pricing);
    }

    public function build()
    {
        return $this->cartItemOptionProductDTO;
    }
}
