<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\AbstractCartPriceRuleItemDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractCartPriceRuleItem implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    private $cartPriceRule_uuid;

    /** @var int */
    protected $quantity;

    /** @var CartPriceRule */
    protected $cartPriceRule;

    public function __construct()
    {
        $this->setUuid();
        $this->setCreated();
    }

    abstract public function matches(CartItem $cartItem);

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

    public function setCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRule = $cartPriceRule;
        $this->setCartPriceRuleUuid($cartPriceRule->getUuid());
    }

    public function getCartPriceRule()
    {
        return $this->cartPriceRule;
    }

    /**
     * @return AbstractCartPriceRuleItemDTOBuilder
     */
    abstract public function getDTOBuilder();

    // TODO: Remove after uuid_migration
    public function setCartPriceRuleUuid(UuidInterface $uuid)
    {
        $this->cartPriceRule_uuid = $uuid;
    }
}
