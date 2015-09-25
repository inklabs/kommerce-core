<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\EntityDTO\CartTotalDTO;

class CartTotalDTOBuilder
{
    /** @var CartTotal */
    protected $cartTotal;

    /** @var CartTotalDTO */
    protected $cartTotalDTO;

    public function __construct(CartTotal $cartTotal)
    {
        $this->cartTotal = $cartTotal;

        $this->cartTotalDTO = new CartTotalDTO;
        $this->cartTotalDTO->origSubtotal     = $this->cartTotal->origSubtotal;
        $this->cartTotalDTO->subtotal         = $this->cartTotal->subtotal;
        $this->cartTotalDTO->taxSubtotal      = $this->cartTotal->taxSubtotal;
        $this->cartTotalDTO->discount         = $this->cartTotal->discount;
        $this->cartTotalDTO->shipping         = $this->cartTotal->shipping;
        $this->cartTotalDTO->shippingDiscount = $this->cartTotal->shippingDiscount;
        $this->cartTotalDTO->tax              = $this->cartTotal->tax;
        $this->cartTotalDTO->total            = $this->cartTotal->total;
        $this->cartTotalDTO->savings          = $this->cartTotal->savings;
    }

    public function withCoupons()
    {
        foreach ($this->cartTotal->coupons as $key => $coupon) {
            $this->cartTotalDTO->coupons[$key] = $coupon->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withCartPriceRules()
    {
        foreach ($this->cartTotal->cartPriceRules as $key => $cartPriceRule) {
            $this->cartTotalDTO->cartPriceRules[$key] = $cartPriceRule->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withCoupons()
            ->withCartPriceRules();
    }

    public function build()
    {
        return $this->cartTotalDTO;
    }
}
