<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateInventoryLocationCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $inventoryLocationId;

    /** @var UuidInterface */
    private $warehouseId;

    /** @var string */
    private $name;

    /** @var string */
    private $code;

    public function __construct(string $warehouseId, string $name, string $code)
    {
        $this->inventoryLocationId = Uuid::uuid4();
        $this->warehouseId = Uuid::fromString($warehouseId);
        $this->name = $name;
        $this->code = $code;
    }

    public function getInventoryLocationId(): UuidInterface
    {
        return $this->inventoryLocationId;
    }

    public function getWarehouseId(): UuidInterface
    {
        return $this->warehouseId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
