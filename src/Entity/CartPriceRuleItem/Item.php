<?php
namespace inklabs\kommerce\Entity\CartPriceRuleItem;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\Accessor;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class Item
{
    use Accessor\Time, Accessor\Id;

    /** @var int */
    protected $quantity;

    /** @var Entity\CartPriceRule */
    protected $cartPriceRule;

    abstract public function matches(Entity\CartItem $cartItem);

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setCartPriceRule(Entity\CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRule = $cartPriceRule;
    }

    public function getCartPriceRule()
    {
        return $this->cartPriceRule;
    }
}
