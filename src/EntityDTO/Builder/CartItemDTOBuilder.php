<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\EntityDTO\CartItemDTO;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\PricingInterface;

class CartItemDTOBuilder
{
    public function __construct(CartItem $cartItem)
    {
        $this->cartItem = $cartItem;

        $this->cartItemDTO = new CartItemDTO;
        $this->cartItemDTO->id             = $this->cartItem->getId();
        $this->cartItemDTO->encodedId      = BaseConvert::encode($this->cartItem->getId());
        $this->cartItemDTO->fullSku        = $this->cartItem->getFullSku();
        $this->cartItemDTO->quantity       = $this->cartItem->getQuantity();
        $this->cartItemDTO->shippingWeight = $this->cartItem->getShippingWeight();
        $this->cartItemDTO->created        = $this->cartItem->getCreated();
        $this->cartItemDTO->updated        = $this->cartItem->getUpdated();
    }

    public function withPrice(PricingInterface $pricing)
    {
        $this->cartItemDTO->price = $this->cartItem->getPrice($pricing)->getDTOBuilder()
            ->withAllData()
            ->build();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $this->cartItemDTO->product = $this->cartItem->getProduct()->getDTOBuilder()
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->build();

        return $this;
    }

    public function withCartItemOptionProducts(PricingInterface $pricing)
    {
        foreach ($this->cartItem->getCartItemOptionProducts() as $cartItemOptionProduct) {
            $this->cartItemDTO->cartItemOptionProducts[] = $cartItemOptionProduct->getDTOBuilder()
                ->withOptionProduct($pricing)
                ->build();
        }

        return $this;
    }

    public function withCartItemOptionValues()
    {
        foreach ($this->cartItem->getCartItemOptionValues() as $cartItemOptionValue) {
            $this->cartItemDTO->cartItemOptionValues[] = $cartItemOptionValue->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withCartItemTextOptionValues()
    {
        foreach ($this->cartItem->getCartItemTextOptionValues() as $cartItemTextOptionValue) {
            $this->cartItemDTO->cartItemTextOptionValues[] = $cartItemTextOptionValue->getDTOBuilder()
                ->withTextOption()
                ->build();
        }

        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withProduct($pricing)
            ->withPrice($pricing)
            ->withCartItemOptionProducts($pricing)
            ->withCartItemOptionValues()
            ->withCartItemTextOptionValues();
    }

    public function build()
    {
        return $this->cartItemDTO;
    }
}
