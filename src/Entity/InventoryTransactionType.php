<?php
namespace inklabs\kommerce\Entity;

use InvalidArgumentException;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryTransactionType implements ValidationInterface
{
    /** @var int */
    private $id;

    const MOVE = 0;
    const HOLD = 1;
    const NEW_PRODUCTS = 2;
    const SHIPPED = 3;
    const RETURNED = 4;
    const PROMOTION = 5;
    const DAMAGED = 6;
    const SHRINKAGE = 7;

    /**
     * @param int $id
     */
    private function __construct($id)
    {
        if (! in_array($id, self::validIds())) {
            throw new InvalidArgumentException;
        }

        $this->id = (int) $id;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('id', new Assert\Choice([
            'choices' => self::validIds(),
            'message' => 'The type is not a valid choice',
        ]));
    }

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

    /**
     * @return array
     */
    private static function validIds()
    {
        return array_keys(self::getNameMap());
    }

    public function getName()
    {
        return $this->getNameMap()[$this->id];
    }


    /**
     * @param int $id
     * @return InventoryTransactionType
     */
    public static function createById($id)
    {
        return new self($id);
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
