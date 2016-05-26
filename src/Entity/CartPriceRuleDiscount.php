<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleDiscountDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CartPriceRuleDiscount implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    use TempUuidTrait;
    private $cartPriceRule_uuid;
    private $product_uuid;

    /** @var int */
    protected $quantity;

    /** @var Product */
    protected $product;

    /** @var CartPriceRule */
    protected $cartPriceRule;

    public function __construct(Product $product, $quantity = 1)
    {
        $this->setUuid();
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;

        $this->setProductUuid($product->getUuid());
    }

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

    public function getProduct()
    {
        return $this->product;
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

    public function getDTOBuilder()
    {
        return new CartPriceRuleDiscountDTOBuilder($this);
    }

    // TODO: Remove after uuid_migration
    public function setCartPriceRuleUuid(UuidInterface $uuid)
    {
        $this->cartPriceRule_uuid = $uuid;
    }

    // TODO: Remove after uuid_migration
    public function setProductUuid(UuidInterface $uuid)
    {
        $this->product_uuid = $uuid;
    }
}
