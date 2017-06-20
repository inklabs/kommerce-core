<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CartPriceRuleTagItem extends AbstractCartPriceRuleItem
{
    /** @var Tag */
    protected $tag;

    public function __construct(Tag $tag, $quantity, UuidInterface $id = null)
    {
        parent::__construct($id);
        $this->tag = $tag;
        $this->quantity = $quantity;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        parent::loadValidatorMetadata($metadata);
    }

    public function matches(CartItem $cartItem): bool
    {
        foreach ($cartItem->getProduct()->getTags() as $tag) {
            if (($tag->getId() === $this->tag->getId())
                and ($cartItem->getQuantity() >= $this->quantity)
            ) {
                return true;
            }
        }

        return false;
    }

    public function getTag(): Tag
    {
        return $this->tag;
    }
}
