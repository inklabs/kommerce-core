<?php
namespace inklabs\kommerce\Action\Inventory;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AdjustInventoryCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $productId;

    /** @var int */
    private $quantity;

    /** @var UuidInterface */
    private $inventoryLocationId;

    /** @var int */
    private $transactionTypeId;

    /**
     * @param string $productId
     * @param int $quantity (can be negative)
     * @param string $inventoryLocationId
     * @param int $transactionTypeId
     */
    public function __construct(
        $productId,
        $quantity,
        $inventoryLocationId,
        $transactionTypeId
    ) {
        $this->productId = Uuid::fromString($productId);
        $this->quantity = (int) $quantity;
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
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
