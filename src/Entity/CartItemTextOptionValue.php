<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CartItemTextOptionValue implements IdEntityInterface, ValidationInterface
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
        $this->setId();
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('textOptionValue', new Assert\NotBlank);
        $metadata->addPropertyConstraint('textOptionValue', new Assert\Length([
            'max' => 255,
        ]));
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
}
