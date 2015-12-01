<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryTransaction implements EntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var InventoryLocation */
    protected $inventoryLocation;

    /** @var Product */
    protected $product;

    /** @var int */
    protected $type;
    const TYPE_MOVE = 0;
    const TYPE_HOLD = 1;
    const TYPE_NEW_PRODUCTS = 2;
    const TYPE_SHIPPED = 3;
    const TYPE_RETURNED = 4;
    const TYPE_PROMOTION = 5;
    const TYPE_DAMAGED = 6;
    const TYPE_SHRINKAGE = 7;

    /** @var int */
    protected $debitQuantity;

    /** @var int */
    protected $creditQuantity;

    /** @var string */
    protected $memo;

    /**
     * @param InventoryLocation $inventoryLocation
     * @param int $type
     */
    public function __construct(InventoryLocation $inventoryLocation = null, $type = self::TYPE_MOVE)
    {
        $this->setCreated();
        $this->setType($type);
        $this->inventoryLocation = $inventoryLocation;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('type', new Assert\Choice([
            'choices' => array_keys(static::getTypeMapping()),
            'message' => 'The type is not a valid choice',
        ]));

        $metadata->addPropertyConstraint('debitQuantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addPropertyConstraint('creditQuantity', new Assert\Range([
            'min' => 0,
            'max' => 65535,
        ]));

        $metadata->addConstraint(new Assert\Callback(
            function (InventoryTransaction $inventoryTransaction, ExecutionContextInterface $context) {
                if (! $inventoryTransaction->isQuantityValid()) {
                    $context->buildViolation('Only DebitQuantity or CreditQuantity should be set')
                        ->atPath('debitQuantity')
                        ->addViolation();

                    $context->buildViolation('Only DebitQuantity or CreditQuantity should be set')
                        ->atPath('creditQuantity')
                        ->addViolation();
                }
            }
        ));

        $metadata->addPropertyConstraint('memo', new Assert\NotBlank);
        $metadata->addPropertyConstraint('memo', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('product', new Assert\NotNull);
        $metadata->addPropertyConstraint('product', new Assert\Valid);

        $metadata->addPropertyConstraint('inventoryLocation', new Assert\Valid);

        $metadata->addConstraint(new Assert\Callback(
            function (InventoryTransaction $inventoryTransaction, ExecutionContextInterface $context) {
                if (! $inventoryTransaction->isLocationValidForMoveOperation()) {
                    $context->buildViolation('InventoryLocation must be set for Move operation')
                        ->atPath('inventoryLocation')
                        ->addViolation();
                }
            }
        ));
    }

    private function isQuantityValid()
    {
        return ($this->getDebitQuantity() !== null ^ $this->getCreditQuantity() !== null);
    }

    private function isLocationValidForMoveOperation()
    {
        if ($this->type === self::TYPE_MOVE && $this->inventoryLocation === null) {
            return false;
        }

        return true;
    }

    /**
     * @param int $quantity
     */
    public function setDebitQuantity($quantity = null)
    {
        $this->debitQuantity = $this->getQuantityOrNull($quantity);
    }

    /**
     * @param int $quantity
     */
    public function setCreditQuantity($quantity = null)
    {
        $this->creditQuantity = $this->getQuantityOrNull($quantity);
    }

    /**
     * @param int $quantity
     * @return int
     */
    protected function getQuantityOrNull($quantity = null)
    {
        if ($quantity !== null) {
            $quantity = (int) $quantity;
        }
        return $quantity;
    }

    /**
     * @param string $memo
     */
    public function setMemo($memo)
    {
        $this->memo = (string) $memo;
    }

    public function getInventoryLocation()
    {
        return $this->inventoryLocation;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getDebitQuantity()
    {
        return $this->debitQuantity;
    }

    public function getCreditQuantity()
    {
        return $this->creditQuantity;
    }

    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = (int) $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public static function getTypeMapping()
    {
        return [
            static::TYPE_MOVE => 'Move',
            static::TYPE_HOLD => 'Hold',
            static::TYPE_NEW_PRODUCTS => 'New Products',
            static::TYPE_SHIPPED => 'Shipped',
            static::TYPE_RETURNED => 'Returned',
            static::TYPE_PROMOTION => 'Promotion',
            static::TYPE_DAMAGED => 'Damaged',
            static::TYPE_SHRINKAGE => 'Shrinkage',
        ];
    }

    public static function getTypeTextFromType($type)
    {
        return self::getTypeMapping()[$type];
    }

    public function getTypeText()
    {
        return $this->getTypeTextFromType($this->type);
    }

    public function getQuantity()
    {
        return $this->creditQuantity - $this->debitQuantity;
    }
}
