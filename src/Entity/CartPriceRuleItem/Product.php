<?php
namespace inklabs\kommerce\Entity\CartPriceRuleItem;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Product extends Item
{
    /** @var Entity\Product */
    protected $product;

    public function __construct(Entity\Product $product, $quantity)
    {
        $this->setCreated();
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        parent::loadValidatorMetadata($metadata);
    }

    public function matches(Entity\CartItem $cartItem)
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

    public function getView()
    {
        return new View\CartPriceRuleItem\Product($this);
    }
}
