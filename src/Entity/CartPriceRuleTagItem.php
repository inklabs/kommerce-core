<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleTagItemDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CartPriceRuleTagItem extends AbstractCartPriceRuleItem
{
    /** @var Tag */
    protected $tag;

    public function __construct(Tag $tag, $quantity)
    {
        parent::__construct();
        $this->tag = $tag;
        $this->quantity = $quantity;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
    }

    public function matches(CartItem $cartItem)
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

    public function getTag()
    {
        return $this->tag;
    }

    public function getDTOBuilder()
    {
        return new CartPriceRuleTagItemDTOBuilder($this);
    }
}
