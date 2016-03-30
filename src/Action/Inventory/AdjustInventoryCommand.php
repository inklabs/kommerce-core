<?php
namespace inklabs\kommerce\Action\Inventory;

final class AdjustInventoryCommand
{
    /** @var int */
    private $productId;

    /** @var int */
    private $quantity;

    /** @var int */
    private $inventoryLocationId;

    /** @var int */
    private $transactionTypeId;

    /**
     * @param int $productId
     * @param int $quantity (can be negative)
     * @param int $inventoryLocationId
     * @param int $transactionTypeId
     */
    public function __construct($productId, $quantity, $inventoryLocationId, $transactionTypeId)
    {
        $this->productId = (int) $productId;
        $this->quantity = (int) $quantity;
        $this->inventoryLocationId = (int) $inventoryLocationId;
        $this->transactionTypeId = (int) $transactionTypeId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getInventoryLocationId()
    {
        return $this->inventoryLocationId;
    }

    public function getTransactionTypeId()
    {
        return $this->transactionTypeId;
    }
}
