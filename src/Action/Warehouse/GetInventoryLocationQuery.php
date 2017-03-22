<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetInventoryLocationQuery implements QueryInterface
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
