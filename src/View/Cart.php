<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Cart implements ViewInterface
{
    public $id;
    public $totalItems;
    public $totalQuantity;
    public $shippingWeight;
    public $shippingWeightInPounds;

    /** @var ShippingRate */
    public $shippingRate;

    /** @var TaxRate */
    public $taxRate;

    /** @var User */
    public $user;

    public $sessionId;

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

        $this->id             = $cart->getId();
        $this->totalItems     = $cart->totalItems();
        $this->totalQuantity  = $cart->totalQuantity();
        $this->shippingWeight = $cart->getShippingWeight();
        $this->shippingWeightInPounds = $cart->getShippingWeightInPounds();
        $this->created        = $cart->getCreated();
        $this->updated        = $cart->getUpdated();

        if ($cart->getShippingRate() !== null) {
            $this->shippingRate = $cart->getShippingRate()->getView()->export();
        }

        if ($cart->getTaxRate() !== null) {
            $this->taxRate = $cart->getTaxRate()->getView()->export();
        }

        if ($cart->getUser() !== null) {
            $this->user = $cart->getUser()->getView()->export();
        }
    }

    public function export()
    {
        unset($this->cart);
        return $this;
    }

    public function withCartTotal(
        Lib\PricingInterface $pricing,
        Entity\ShippingRate $shippingRate = null,
        Entity\TaxRate $taxRate = null
    ) {
        $this->cartTotal = $this->cart->getTotal($pricing, $shippingRate, $taxRate)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withCartItems(Lib\PricingInterface $pricing)
    {
        foreach ($this->cart->getCartItems() as $cartItemIndex => $cartItem) {
            $this->cartItems[$cartItemIndex] = $cartItem->getView()
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
        Entity\ShippingRate $shippingRate = null,
        Entity\TaxRate $taxRate = null
    ) {
        return $this
            ->withCartTotal($pricing, $shippingRate, $taxRate)
            ->withCartItems($pricing)
            ->withCoupons();
    }
}
