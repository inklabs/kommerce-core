<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\Service\Pricing;

class CartItem
{
    public $id;
    public $product;
    public $quantity;
    public $shippingWeight;
    public $price;
    public $created;
    public $updated;

    public function __construct(Entity\CartItem $cartItem)
    {
        $this->cartItem = $cartItem;

        $this->id             = $cartItem->getId();
        $this->quantity       = $cartItem->getQuantity();
        $this->shippingWeight = $cartItem->getShippingWeight();
        $this->created        = $cartItem->getCreated();
        $this->updated        = $cartItem->getUpdated();

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

    public function withPrice(Pricing $pricing)
    {
        $this->price = Price::factory($this->cartItem->getPrice($pricing))
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $this->product = Product::factory($this->cartItem->getProduct())
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->export();

        return $this;
    }

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withProduct($pricing)
            ->withPrice($pricing);
    }
}
