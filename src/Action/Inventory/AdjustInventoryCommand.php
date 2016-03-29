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
    private $transactionType;

    /**
     * @param int $productId
     * @param int $quantity (can be negative)
     * @param int $inventoryLocationId
     * @param int $transactionType
     */
    public function __construct($productId, $quantity, $inventoryLocationId, $transactionType)
    {
        $this->productId = (int) $productId;
        $this->quantity = (int) $quantity;
        $this->inventoryLocationId = (int) $inventoryLocationId;
        $this->transactionType = (int) $transactionType;
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

    public function getTransactionType()
    {
        return $this->transactionType;
    }
}
