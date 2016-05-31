<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\EntityDTO\CartItemOptionProductDTO;
use inklabs\kommerce\Lib\PricingInterface;

class CartItemOptionProductDTOBuilder
{
    /** @var CartItemOptionProduct */
    private $cartItemOptionProduct;

    /** @var CartItemOptionProductDTO  */
    private $cartItemOptionProductDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        CartItemOptionProduct $cartItemOptionProduct,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->cartItemOptionProduct = $cartItemOptionProduct;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->cartItemOptionProductDTO = new CartItemOptionProductDTO;
        $this->cartItemOptionProductDTO->id      = $this->cartItemOptionProduct->getId();
        $this->cartItemOptionProductDTO->created = $this->cartItemOptionProduct->getCreated();
        $this->cartItemOptionProductDTO->updated = $this->cartItemOptionProduct->getUpdated();

        $this->cartItemOptionProductDTO->optionProduct = $this->dtoBuilderFactory
            ->getOptionProductDTOBuilder($this->cartItemOptionProduct->getOptionProduct())
            ->build();
    }

    public function withOptionProduct(PricingInterface $pricing)
    {
        $this->cartItemOptionProductDTO->optionProduct = $this->dtoBuilderFactory
            ->getOptionProductDTOBuilder($this->cartItemOptionProduct->getOptionProduct())
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
