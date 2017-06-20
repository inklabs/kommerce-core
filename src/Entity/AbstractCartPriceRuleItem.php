<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractCartPriceRuleItem implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $quantity;

    /** @var CartPriceRule */
    protected $cartPriceRule;

    public function __construct(UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();
    }

    abstract public function matches(CartItem $cartItem): bool;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
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

    public function setCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRule = $cartPriceRule;
    }

    public function getCartPriceRule(): CartPriceRule
    {
        return $this->cartPriceRule;
    }
}
