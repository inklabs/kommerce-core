<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleTagItemDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CartPriceRuleTagItem extends AbstractCartPriceRuleItem
{
    /** @var Tag */
    protected $tag;
    private $tag_uuid;

    public function __construct(Tag $tag, $quantity)
    {
        parent::__construct();
        $this->tag = $tag;
        $this->quantity = $quantity;

        $this->setTagUuid($tag->getUuid());
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

    // TODO: Remove after uuid_migration
    public function setTagUuid(UuidInterface $uuid)
    {
        $this->tag_uuid = $uuid;
    }
}
