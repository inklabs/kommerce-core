<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Entity\Shipping as Shipping;
use inklabs\kommerce\Lib;

class Cart implements ViewInterface
{
    public $totalItems;
    public $totalQuantity;
    public $shippingWeight;
    public $created;
    public $updated;

    /** @var CartTotal */
    public $cartTotal;

    /** @var CartItem[] */
    public $cartItems = [];

    /** @var Coupon[] */
    public $coupons = [];

    public function __construct(Entity\Cart $cart)
    {
        $this->cart = $cart;

        $this->totalItems     = $cart->totalItems();
        $this->totalQuantity  = $cart->totalQuantity();
        $this->shippingWeight = $cart->getShippingWeight();
        $this->created        = $cart->getCreated();
        $this->updated        = $cart->getUpdated();
    }

    public function export()
    {
        unset($this->cart);
        return $this;
    }

    public function withCartTotal(
        Lib\PricingInterface $pricing,
        Shipping\Rate $shippingRate = null,
        Entity\TaxRate $taxRate = null
    ) {
        $this->cartTotal = $this->cart->getTotal($pricing, $shippingRate, $taxRate)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withCartItems(Lib\PricingInterface $pricing)
    {
        foreach ($this->cart->getCartItems() as $key => $cartItem) {
            $this->cartItems[$key] = $cartItem->getView()
                ->withAllData($pricing)
                ->export();
        }

        return $this;
    }

    public function withCoupons()
    {
        foreach ($this->cart->getCoupons() as $key => $coupon) {
            $this->coupons[$key] = $coupon->getView()
                ->export();
        }

        return $this;
    }

    public function withAllData(
        Lib\PricingInterface $pricing,
        Shipping\Rate $shippingRate = null,
        Entity\TaxRate $taxRate = null
    ) {
        return $this
            ->withCartTotal($pricing, $shippingRate, $taxRate)
            ->withCartItems($pricing)
            ->withCoupons();
    }
}
