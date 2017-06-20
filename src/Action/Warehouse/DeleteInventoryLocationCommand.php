<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteInventoryLocationCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $inventoryLocationId;

    public function __construct(string $inventoryLocationId)
    {
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
    }

    public function getInventoryLocationId(): UuidInterface
    {
        return $this->inventoryLocationId;
    }
}
