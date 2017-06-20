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

    public function __construct(string $name, string $code, string $inventoryLocationId)
    {
        $this->name = $name;
        $this->code = $code;
        $this->inventoryLocationId = Uuid::fromString($inventoryLocationId);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getInventoryLocationId(): UuidInterface
    {
        return $this->inventoryLocationId;
    }
}
