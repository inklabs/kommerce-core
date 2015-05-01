<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\Service\Pricing;

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

    public function withPrice(Pricing $pricing)
    {
        $this->price = $this->cartItem->getPrice($pricing)->getView()
            ->withAllData()
            ->export();

        return $this;
    }

    public function withProduct(Pricing $pricing)
    {
        $this->product = $this->cartItem->getProduct()->getView()
            ->withTags()
            ->withProductQuantityDiscounts($pricing)
            ->export();

        return $this;
    }

    public function withCartItemOptionProducts(Pricing $pricing)
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

    public function withAllData(Pricing $pricing)
    {
        return $this
            ->withProduct($pricing)
            ->withPrice($pricing)
            ->withCartItemOptionProducts($pricing)
            ->withCartItemOptionValues()
            ->withCartItemTextOptionValues();
    }
}
