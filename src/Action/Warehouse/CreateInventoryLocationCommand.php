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

    /**
     * @param string $warehouseId
     * @param string $name
     * @param string $code
     */
    public function __construct($warehouseId, $name, $code)
    {
        $this->inventoryLocationId = Uuid::uuid4();
        $this->warehouseId = Uuid::fromString($warehouseId);
        $this->name = $name;
        $this->code = $code;
    }

    public function getInventoryLocationId()
    {
        return $this->inventoryLocationId;
    }

    public function getWarehouseId()
    {
        return $this->warehouseId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }
}
