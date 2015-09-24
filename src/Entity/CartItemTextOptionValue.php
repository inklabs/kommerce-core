<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;

class CartItemTextOptionValue
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $textOptionValue;

    /** @var TextOption */
    protected $textOption;

    /** @var CartItem */
    protected $cartItem;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getTextOption()
    {
        return $this->textOption;
    }

    public function setTextOption(TextOption $textOption)
    {
        $this->textOption = $textOption;
    }

    public function getTextOptionValue()
    {
        return $this->textOptionValue;
    }

    /**
     * @param string $textOptionValue
     */
    public function setTextOptionValue($textOptionValue)
    {
        $this->textOptionValue = $textOptionValue;
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
        return new View\CartItemTextOptionValue($this);
    }
}
