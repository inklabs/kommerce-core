<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class CartItem
{
    public $id;
    public $product;
    public $quantity;
    public $price;

    private $cartItem;

    public function __construct(Entity\CartItem $cartItem)
    {
        $this->cartItem = $cartItem;

        $this->id       = $cartItem->getId();
        $this->quantity = $cartItem->getQuantity();
        $this->created  = $cartItem->getCreated();
        $this->updated  = $cartItem->getUpdated();

        return $this;
    }

    public static function factory(Entity\CartItem $cartItem)
    {
        return new static($cartItem);
    }

    public function export()
    {
        unset($this->cartItem);
        return $this;
    }

    public function withPrice(\inklabs\kommerce\Service\Pricing $pricing)
    {
        $this->price = Price::factory($this->cartItem->getPrice($pricing))
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(\inklabs\kommerce\Service\Pricing $pricing)
    {
        $this->product = Product::factory($this->cartItem->getProduct())
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->export();

        return $this;
    }

    public function withAllData(\inklabs\kommerce\Service\Pricing $pricing)
    {
        return $this
            ->withProduct($pricing)
            ->withPrice($pricing);
    }
}
