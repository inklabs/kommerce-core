<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class UpdateInventoryLocationCommand implements CommandInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $code;

    /** @var UuidInterface */
    private $inventoryLocationId;

    /**
     * @param string $name
     * @param string $code
     * @param string $inventoryLocationId
     */
    public function __construct($name, $code, $inventoryLocationId)
    {
        $this->name = $name;
        $this->code = $code;
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getInventoryLocationId()
    {
        return $this->inventoryLocationId;
    }
}
