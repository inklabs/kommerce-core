<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CartItemTextOptionValue implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $textOptionValue;

    /** @var TextOption|null */
    protected $textOption;

    /** @var CartItem|null */
    protected $cartItem;

    public function __construct(string $textOptionValue, UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->textOptionValue = $textOptionValue;
    }

    public function __clone()
    {
        $this->setId();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('textOptionValue', new Assert\NotBlank);
        $metadata->addPropertyConstraint('textOptionValue', new Assert\Length([
            'max' => 255,
        ]));
    }

    public function getTextOption(): ?TextOption
    {
        return $this->textOption;
    }

    public function setTextOption(TextOption $textOption)
    {
        $this->textOption = $textOption;
    }

    public function getTextOptionValue(): string
    {
        return $this->textOptionValue;
    }

    public function setTextOptionValue(string $textOptionValue)
    {
        $this->textOptionValue = $textOptionValue;
    }

    public function getCartItem(): ?CartItem
    {
        return $this->cartItem;
    }

    public function setCartItem(CartItem $cartItem)
    {
        $this->cartItem = $cartItem;
    }
}
