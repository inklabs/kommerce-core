<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\InventoryTransactionTypeDTOBuilder;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @method static InventoryTransactionType createById($id)
 */
class InventoryTransactionType extends AbstractIntegerType
{
    const MOVE = 0;
    const HOLD = 1;
    const NEW_PRODUCTS = 2;
    const SHIPPED = 3;
    const RETURNED = 4;
    const PROMOTION = 5;
    const DAMAGED = 6;
    const SHRINKAGE = 7;

    public static function getNameMap()
    {
        return [
            self::MOVE => 'Move',
            self::HOLD => 'Hold',
            self::NEW_PRODUCTS => 'New Products',
            self::SHIPPED => 'Shipped',
            self::RETURNED => 'Returned',
            self::PROMOTION => 'Promotion',
            self::DAMAGED => 'Damaged',
            self::SHRINKAGE => 'Shrinkage',
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

    public static function move()
    {
        return new self(self::MOVE);
    }

    public static function hold()
    {
        return new self(self::HOLD);
    }

    public static function newProducts()
    {
        return new self(self::NEW_PRODUCTS);
    }

    public static function shipped()
    {
        return new self(self::SHIPPED);
    }

    public static function returned()
    {
        return new self(self::RETURNED);
    }

    public static function promotion()
    {
        return new self(self::PROMOTION);
    }

    public static function damaged()
    {
        return new self(self::DAMAGED);
    }

    public static function shrinkage()
    {
        return new self(self::SHRINKAGE);
    }

    public function isMove()
    {
        return $this->id === self::MOVE;
    }

    public function isHold()
    {
        return $this->id === self::HOLD;
    }

    public function isNewProducts()
    {
        return $this->id === self::NEW_PRODUCTS;
    }

    public function isShipped()
    {
        return $this->id === self::SHIPPED;
    }

    public function isReturned()
    {
        return $this->id === self::RETURNED;
    }

    public function isPromotion()
    {
        return $this->id === self::PROMOTION;
    }

    public function isDamaged()
    {
        return $this->id === self::DAMAGED;
    }

    public function isShrinkage()
    {
        return $this->id === self::SHRINKAGE;
    }
}
