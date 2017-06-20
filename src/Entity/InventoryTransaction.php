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

    private function __construct(
        Product $product,
        InventoryLocation $inventoryLocation,
        int $quantity,
        string $memo,
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

    public static function newProduct(
        InventoryLocation $inventoryLocation,
        Product $product,
        int $quantity
    ): InventoryTransaction {
        return self::credit(
            $product,
            $quantity,
            'Initial Inventory',
            $inventoryLocation,
            InventoryTransactionType::newProducts()
        );
    }

    public static function debit(
        Product $product,
        int $quantity,
        string $memo,
        InventoryLocation $inventoryLocation,
        InventoryTransactionType $transactionType = null
    ): InventoryTransaction {
        $quantity = -1 * abs($quantity);
        return new self($product, $inventoryLocation, $quantity, $memo, $transactionType);
    }

    public static function credit(
        Product $product,
        int $quantity,
        string $memo,
        InventoryLocation $inventoryLocation,
        InventoryTransactionType $transactionType = null
    ): InventoryTransaction {
        return new self($product, $inventoryLocation, $quantity, $memo, $transactionType);
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('quantity', new Assert\NotNull);
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

    public function setMemo(string $memo)
    {
        $this->memo = $memo;
    }

    public function getInventoryLocation(): InventoryLocation
    {
        return $this->inventoryLocation;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getMemo(): string
    {
        return $this->memo;
    }

    public function getType(): InventoryTransactionType
    {
        return $this->type;
    }
}
