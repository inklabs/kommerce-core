<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\Shipping as Shipping;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class Cart
{
    public $items = [];
    public $coupons = [];
    public $totalItems;
    public $totalQuantity;
    public $shippingWeight;
    public $cartTotal;

    public function __construct(Entity\Cart $cart)
    {
        $this->cart = $cart;

        $this->items          = $cart->getItems();
        $this->coupons        = $cart->getCoupons();
        $this->totalItems     = $cart->totalItems();
        $this->totalQuantity  = $cart->totalQuantity();
        $this->shippingWeight = $cart->getShippingWeight();

        return $this;
    }

    public static function factory(Entity\Cart $cart)
    {
        return new static($cart);
    }

    public function export()
    {
        unset($this->cart);
        return $this;
    }

    public function withCartTotal(Pricing $pricing, Shipping\Rate $shippingRate = null)
    {
        $this->cartTotal = $this->cart->getTotal($pricing, $shippingRate);

        return $this;
    }

    public function withCartItems(Pricing $pricing)
    {
        foreach ($this->cart->getItems() as $cartItem) {
            $this->items[$cartItem->getId()] = CartItem::factory($cartItem)
                ->withAllData($pricing)
                ->export();
        }

        return $this;
    }

    public function withAllData(Pricing $pricing, Shipping\Rate $shippingRate = null)
    {
        return $this
            ->withCartItems($pricing)
            ->withCartTotal($pricing, $shippingRate);
    }
}
