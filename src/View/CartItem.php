<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class CartItem implements ViewInterface
{
    public $id;
    public $encodedId;
    public $fullSku;
    public $quantity;
    public $shippingWeight;
    public $created;

    /** @var Product */
    public $product;

    /** @var CartItemOptionProduct[] */
    public $cartItemOptionProducts = [];

    /** @var CartItemOptionValue[] */
    public $cartItemOptionValues = [];

    /** @var CartItemTextOptionValue[] */
    public $cartItemTextOptionValues = [];

    /** @var Price */
    public $price;

    public function __construct(Entity\CartItem $cartItem)
    {
        $this->cartItem = $cartItem;

        $this->id             = $cartItem->getId();
        $this->encodedId      = Lib\BaseConvert::encode($cartItem->getId());
        $this->fullSku        = $cartItem->getFullSku();
        $this->quantity       = $cartItem->getQuantity();
        $this->shippingWeight = $cartItem->getShippingWeight();
        $this->created        = $cartItem->getCreated();
    }

    public function export()
    {
        unset($this->cartItem);
        return $this;
    }

    public function withPrice(Lib\Pricing $pricing)
    {
        $this->price = $this->cartItem->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Lib\Pricing $pricing)
    {
        $this->product = $this->cartItem->getProduct()->getView()
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->export();

        return $this;
    }

    public function withCartItemOptionProducts(Lib\Pricing $pricing)
    {
        foreach ($this->cartItem->getCartItemOptionProducts() as $cartItemOptionProduct) {
            $this->cartItemOptionProducts[] = $cartItemOptionProduct->getView()
                ->withOptionProduct($pricing)
                ->export();
        }

        return $this;
    }

    public function withCartItemOptionValues()
    {
        foreach ($this->cartItem->getCartItemOptionValues() as $cartItemOptionValue) {
            $this->cartItemOptionValues[] = $cartItemOptionValue->getView()
                ->export();
        }

        return $this;
    }

    public function withCartItemTextOptionValues()
    {
        foreach ($this->cartItem->getCartItemTextOptionValues() as $cartItemTextOptionValue) {
            $this->cartItemTextOptionValues[] = $cartItemTextOptionValue->getView()
                ->withTextOption()
                ->export();
        }

        return $this;
    }

    public function withAllData(Lib\Pricing $pricing)
    {
        return $this
            ->withProduct($pricing)
            ->withPrice($pricing)
            ->withCartItemOptionProducts($pricing)
            ->withCartItemOptionValues()
            ->withCartItemTextOptionValues();
    }
}
