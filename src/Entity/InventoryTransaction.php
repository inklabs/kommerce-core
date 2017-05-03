<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class InventoryTransaction implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var int */
    protected $quantity;

    /** @var string */
    protected $memo;

    /** @var InventoryLocation */
    protected $inventoryLocation;

    /** @var Product */
    protected $product;

    /** @var InventoryTransactionType */
    protected $type;

    /**
     * Used when type is hold
     * @var null|OrderItem
     */
    protected $orderItem;

    /**
     * @param Product $product
     * @param InventoryLocation $inventoryLocation
     * @param int $quantity
     * @param string $memo
     * @param InventoryTransactionType $inventoryTransactionType
     */
    private function __construct(
        Product $product,
        InventoryLocation $inventoryLocation,
        $quantity,
        $memo,
        InventoryTransactionType $inventoryTransactionType = null
    ) {
        if ($inventoryTransactionType === null) {
            $inventoryTransactionType = InventoryTransactionType::move();
        }

        $this->setId();
        $this->setCreated();
        $this->product = $product;
        $this->inventoryLocation = $inventoryLocation;
        $this->quantity = $quantity;
        $this->memo = $memo;
        $this->type = $inventoryTransactionType;
    }

    /**
     * @param InventoryLocation $inventoryLocation
     * @param Product $product
     * @param int $quantity
     * @return InventoryTransaction
     */
    public static function newProduct(InventoryLocation $inventoryLocation, Product $product, $quantity)
    {
        return self::credit(
            $product,
            $quantity,
            'Initial Inventory',
            $inventoryLocation,
            InventoryTransactionType::newProducts()
        );
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param string $memo
     * @param InventoryLocation $inventoryLocation
     * @param InventoryTransactionType $transactionType
     * @return InventoryTransaction
     */
    public static function debit(
        Product $product,
        $quantity,
        $memo,
        InventoryLocation $inventoryLocation,
        InventoryTransactionType $transactionType = null
    ) {
        $quantity = -1 * abs($quantity);
        return new self($product, $inventoryLocation, $quantity, $memo, $transactionType);
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param string $memo
     * @param InventoryLocation $inventoryLocation
     * @param InventoryTransactionType $transactionType
     * @return InventoryTransaction
     */
    public static function credit(
        Product $product,
        $quantity,
        $memo,
        InventoryLocation $inventoryLocation,
        InventoryTransactionType $transactionType = null
    ) {
        return new self($product, $inventoryLocation, $quantity, $memo, $transactionType);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('quantity', new Assert\Range([
            'min' => -32768,
            'max' => 32767,
        ]));
        $metadata->addPropertyConstraint('quantity', new Assert\NotEqualTo([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('memo', new Assert\NotBlank);
        $metadata->addPropertyConstraint('memo', new Assert\Length([
            'max' => 255,
        ]));

        $metadata->addPropertyConstraint('product', new Assert\NotNull);
        $metadata->addPropertyConstraint('product', new Assert\Valid);

        $metadata->addPropertyConstraint('type', new Assert\Valid);
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

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getMemo()
    {
        return $this->memo;
    }

    public function getType()
    {
        return $this->type;
    }
}
