<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Cart
{
    public $items = [];
    public $coupons = [];
    public $totalItems;
    public $totalQuantity;
    public $cartTotal;

    private $cart;

    public function __construct(Entity\Cart $cart)
    {
        $this->cart = $cart;

        $this->items         = $cart->getItems();
        $this->coupons       = $cart->getCoupons();
        $this->totalItems    = $cart->totalItems();
        $this->totalQuantity = $cart->totalQuantity();

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

    public function withCartTotal(\inklabs\kommerce\Service\Pricing $pricing)
    {
        $this->cartTotal = $this->cart->getTotal($pricing);

        return $this;
    }

    public function withCartItems(\inklabs\kommerce\Service\Pricing $pricing)
    {
        foreach ($this->cart->getItems() as $cartItem) {
            $this->items[$cartItem->getId()] = CartItem::factory($cartItem)
                ->withAllData($pricing)
                ->export();
        }

        return $this;
    }

    public function withAllData(\inklabs\kommerce\Service\Pricing $pricing)
    {
        return $this
            ->withCartItems($pricing)
            ->withCartTotal($pricing);
    }
}
