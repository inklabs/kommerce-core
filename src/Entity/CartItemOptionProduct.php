<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use inklabs\kommerce\Service;

class CartItemOptionProduct
{
    use Accessor\Time, Accessor\Id;

    /** @var OptionProduct */
    protected $optionProduct;

    /** @var CartItem */
    protected $cartItem;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getOptionProduct()
    {
        return $this->optionProduct;
    }

    public function setOptionProduct(OptionProduct $optionProduct)
    {
        $this->optionProduct = $optionProduct;
    }

    public function getSku()
    {
        return $this->optionProduct->getSku();
    }

    public function getPrice(Service\Pricing $pricing, $quantity = 1)
    {
        return $this->optionProduct->getPrice($pricing, $quantity);
    }

    public function getShippingWeight()
    {
        return $this->optionProduct->getShippingWeight();
    }

    public function getCartItem()
    {
        return $this->cartItem;
    }

    public function setCartItem(CartItem $cartItem)
    {
        $this->cartItem = $cartItem;
    }

    public function getView()
    {
        return new View\CartItemOptionProduct($this);
    }
}
