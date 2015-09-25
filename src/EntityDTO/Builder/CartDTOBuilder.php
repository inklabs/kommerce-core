<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\CartCalculatorInterface;

class CartDTOBuilder
{
    /** @var Cart */
    protected $cart;

    /** @var CartDTO */
    protected $cartDTO;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;

        $this->cartDTO = new CartDTO;
        $this->cartDTO->id             = $this->cart->getId();
        $this->cartDTO->totalItems     = $this->cart->totalItems();
        $this->cartDTO->totalQuantity  = $this->cart->totalQuantity();
        $this->cartDTO->shippingWeight = $this->cart->getShippingWeight();
        $this->cartDTO->created        = $this->cart->getCreated();
        $this->cartDTO->updated        = $this->cart->getUpdated();

        $this->cartDTO->shippingWeightInPounds = $this->cart->getShippingWeightInPounds();

        if ($cart->getShippingRate() !== null) {
            $this->cartDTO->shippingRate = $cart->getShippingRate()->getDTOBuilder()
                ->build();
        }

        if ($cart->getTaxRate() !== null) {
            $this->cartDTO->taxRate = $cart->getTaxRate()->getDTOBuilder()
                ->build();
        }

        if ($cart->getUser() !== null) {
            $this->cartDTO->user = $cart->getUser()->getDTOBuilder()
                ->build();
        }
    }

    public function withCartTotal(CartCalculatorInterface $cartCalculator)
    {
        $this->cartDTO->cartTotal = $this->cart->getTotal($cartCalculator)->getDTOBuilder()
            ->withAllData()
            ->build();

        return $this;
    }

    public function withCartItems(CartCalculator $cartCalculator)
    {
        foreach ($this->cart->getCartItems() as $cartItemIndex => $cartItem) {
            $this->cartDTO->cartItems[$cartItemIndex] = $cartItem->getDTOBuilder()
                ->withAllData($cartCalculator->getPricing())
                ->build();
        }

        return $this;
    }

    public function withCoupons()
    {
        foreach ($this->cart->getCoupons() as $key => $coupon) {
            $this->cartDTO->coupons[$key] = $coupon->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withAllData(CartCalculator $cartCalculator)
    {
        return $this
            ->withCartTotal($cartCalculator)
            ->withCartItems($cartCalculator)
            ->withCoupons();
    }

    public function build()
    {
        return $this->cartDTO;
    }
}
