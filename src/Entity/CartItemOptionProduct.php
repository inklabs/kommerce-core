<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CartItemOptionProductDTOBuilder;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;

class CartItemOptionProduct
{
    use TimeTrait, IdTrait;

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

    public function getPrice(Lib\PricingInterface $pricing, $quantity = 1)
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

    public function getDTOBuilder()
    {
        return new CartItemOptionProductDTOBuilder($this);
    }
}
