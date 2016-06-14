<?php
namespace inklabs\kommerce\Entity;

class CartItemOptionValue
{
    use TimeTrait, IdTrait;

    /** @var OptionValue */
    protected $optionValue;

    /** @var CartItem */
    protected $cartItem;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();
    }

    public function getOptionValue()
    {
        return $this->optionValue;
    }

    public function setOptionValue(OptionValue $optionValue)
    {
        $this->optionValue = $optionValue;
    }

    public function getSku()
    {
        return $this->optionValue->getSku();
    }

    public function getPrice($quantity = 1)
    {
        return $this->optionValue->getPrice($quantity);
    }

    public function getShippingWeight()
    {
        return $this->optionValue->getShippingWeight();
    }

    public function getCartItem()
    {
        return $this->cartItem;
    }

    public function setCartItem(CartItem $cartItem)
    {
        $this->cartItem = $cartItem;
    }
}
