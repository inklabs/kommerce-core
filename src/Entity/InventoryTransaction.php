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

    /** @var int */
    protected $type;
    const TYPE_MOVE = 0;
    const TYPE_HOLD = 1;

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
    public function __construct(InventoryLocation $inventoryLocation, $type = self::TYPE_MOVE)
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
                if ($inventoryTransaction->isQuantityInvalid()) {
                    $context->buildViolation('Both DebitQuantity and CreditQuantity should not be null')
                        ->atPath('debitQuantity')
                        ->addViolation();

                    $context->buildViolation('Both DebitQuantity and CreditQuantity should not be null')
                        ->atPath('creditQuantity')
                        ->addViolation();
                }
            }
        ));

        $metadata->addPropertyConstraint('memo', new Assert\NotBlank);
        $metadata->addPropertyConstraint('memo', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('inventoryLocation', new Assert\Valid);
    }

    private function isQuantityInvalid()
    {
        return ($this->getDebitQuantity() === null && $this->getCreditQuantity() === null);
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
        ];
    }

    public function getTypeText()
    {
        return $this->getTypeMapping()[$this->type];
    }
}
