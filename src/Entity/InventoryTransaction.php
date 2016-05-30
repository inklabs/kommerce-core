<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\InventoryTransactionDTOBuilder;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryTransaction implements IdEntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $debitQuantity;

    /** @var int */
    protected $creditQuantity;

    /** @var string */
    protected $memo;

    /** @var InventoryLocation */
    protected $inventoryLocation;

    /** @var Product */
    protected $product;

    /** @var InventoryTransactionType */
    protected $type;

    public function __construct(InventoryLocation $inventoryLocation = null, InventoryTransactionType $type = null)
    {
        if ($type === null) {
            $type = InventoryTransactionType::move();
        }

        $this->setId();
        $this->setCreated();
        $this->inventoryLocation = $inventoryLocation;
        $this->type = $type;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
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
        $metadata->addPropertyConstraint('type', new Assert\Valid);

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
        if ($this->type->isMove() && $this->inventoryLocation === null) {
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

    public function getType()
    {
        return $this->type;
    }

    public function getQuantity()
    {
        return $this->creditQuantity - $this->debitQuantity;
    }
}
