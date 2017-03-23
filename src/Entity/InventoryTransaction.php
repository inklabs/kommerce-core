<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryTransaction implements IdEntityInterface
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

    /**
     * @param string $memo
     * @param InventoryTransactionType $inventoryTransactionType
     */
    public function __construct($memo, InventoryTransactionType $inventoryTransactionType = null)
    {
        if ($inventoryTransactionType === null) {
            $inventoryTransactionType = InventoryTransactionType::move();
        }

        $this->setId();
        $this->setCreated();
        $this->type = $inventoryTransactionType;
        $this->memo = $memo;
    }

    /**
     * @param InventoryLocation $inventoryLocation
     * @param Product $product
     * @param int $creditQuantity
     * @return InventoryTransaction
     */
    public static function newProduct(InventoryLocation $inventoryLocation, Product $product, $creditQuantity)
    {
        $inventoryTransaction = new self('Initial inventory', InventoryTransactionType::newProducts());
        $inventoryTransaction->setInventoryLocation($inventoryLocation);
        $inventoryTransaction->setProduct($product);
        $inventoryTransaction->setCreditQuantity($creditQuantity);
        return $inventoryTransaction;
    }

    /**
     * @param InventoryLocation $inventoryLocation
     * @param InventoryTransactionType $transactionType
     * @param Product $product
     * @param int $quantity
     * @param string $memo
     * @return InventoryTransaction
     */
    public static function debit(
        Product $product,
        $quantity,
        $memo,
        InventoryLocation $inventoryLocation = null,
        InventoryTransactionType $transactionType = null
    ) {
        $inventoryTransaction = new self($memo, $transactionType);
        $inventoryTransaction->setInventoryLocation($inventoryLocation);
        $inventoryTransaction->setProduct($product);
        $inventoryTransaction->setDebitQuantity($quantity);
        return $inventoryTransaction;
    }

    /**
     * @param InventoryLocation $inventoryLocation
     * @param InventoryTransactionType $transactionType
     * @param Product $product
     * @param int $quantity
     * @param string $memo
     * @return InventoryTransaction
     */
    public static function credit(
        Product $product,
        $quantity,
        $memo,
        InventoryLocation $inventoryLocation = null,
        InventoryTransactionType $transactionType = null
    ) {
        $inventoryTransaction = new self($memo, $transactionType);
        $inventoryTransaction->setInventoryLocation($inventoryLocation);
        $inventoryTransaction->setProduct($product);
        $inventoryTransaction->setCreditQuantity($quantity);
        return $inventoryTransaction;
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

    private function setInventoryLocation(InventoryLocation $inventoryLocation = null)
    {
        $this->inventoryLocation = $inventoryLocation;
    }
}
