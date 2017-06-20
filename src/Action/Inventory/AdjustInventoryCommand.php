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

    public function __construct(
        string $productId,
        int $quantity,
        string $inventoryLocationId,
        int $transactionTypeId
    ) {
        $this->productId = Uuid::fromString($productId);
        $this->quantity = $quantity;
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
        $this->transactionTypeId = $transactionTypeId;
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getInventoryLocationId(): UuidInterface
    {
        return $this->inventoryLocationId;
    }

    public function getTransactionTypeId(): int
    {
        return $this->transactionTypeId;
    }
}
