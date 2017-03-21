<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteInventoryLocationCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $inventoryLocationId;

    /**
     * @param string $inventoryLocationId
     */
    public function __construct($inventoryLocationId)
    {
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
    }

    public function getInventoryLocationId()
    {
        return $this->inventoryLocationId;
    }
}
