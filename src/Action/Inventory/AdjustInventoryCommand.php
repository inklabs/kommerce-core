<?php
namespace inklabs\kommerce\Action\Inventory;

use inklabs\kommerce\Lib\Command\CommandInterface;
use Ramsey\Uuid\UuidInterface;

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
     * @param UuidInterface $productId
     * @param int $quantity (can be negative)
     * @param UuidInterface $inventoryLocationId
     * @param int $transactionTypeId
     */
    public function __construct(
        UuidInterface $productId,
        $quantity,
        UuidInterface $inventoryLocationId,
        $transactionTypeId
    ) {
        $this->productId = $productId;
        $this->quantity = (int) $quantity;
        $this->inventoryLocationId = $inventoryLocationId;
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
