<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\PricingInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CartItemOptionProduct implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var OptionProduct|null */
    protected $optionProduct;

    /** @var CartItem|null */
    protected $cartItem;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        // TODO: Implement loadValidatorMetadata() method.
    }

    public function __clone()
    {
        $this->setId();
    }

    public function getOptionProduct(): ?OptionProduct
    {
        return $this->optionProduct;
    }

    public function setOptionProduct(OptionProduct $optionProduct)
    {
        $this->optionProduct = $optionProduct;
    }

    public function getSku(): string
    {
        return $this->optionProduct->getSku();
    }

    public function getPrice(PricingInterface $pricing, $quantity = 1): Price
    {
        return $this->optionProduct->getPrice($pricing, $quantity);
    }

    public function getShippingWeight(): int
    {
        return $this->optionProduct->getShippingWeight();
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
