<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CartPriceRuleDiscount implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $quantity;

    /** @var Product */
    protected $product;

    /** @var CartPriceRule|null */
    protected $cartPriceRule;

    public function __construct(Product $product, $quantity = 1)
    {
        $this->setId();
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRule = $cartPriceRule;
    }

    public function getCartPriceRule(): ?CartPriceRule
    {
        return $this->cartPriceRule;
    }
}
