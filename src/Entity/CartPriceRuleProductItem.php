<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CartPriceRuleProductItemDTOBuilder;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class CartPriceRuleProductItem extends AbstractCartPriceRuleItem
{
    /** @var Product */
    protected $product;

    public function __construct(Product $product, $quantity)
    {
        parent::__construct();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
    }

    public function matches(CartItem $cartItem)
    {
        if ($cartItem->getProduct()->getId() == $this->product->getId()
            and $cartItem->getQuantity() >= $this->quantity
        ) {
            return true;
        }

        return false;
    }

    public function getProduct()
    {
        return $this->product;
    }
}
