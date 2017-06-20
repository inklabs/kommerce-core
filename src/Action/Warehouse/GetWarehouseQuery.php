<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetWarehouseQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $warehouseId;

    public function __construct(string $warehouseId)
    {
        $this->warehouseId = Uuid::fromString($warehouseId);
    }

    public function getWarehouseId(): UuidInterface
    {
        return $this->warehouseId;
    }
}
