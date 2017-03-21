<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\CreateInventoryLocationCommand;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\EntityDTO\Builder\InventoryLocationDTOBuilder;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateInventoryLocationHandler implements CommandHandlerInterface
{
    /** @var CreateInventoryLocationCommand */
    private $command;

    /** @var WarehouseRepositoryInterface */
    protected $warehouseRepository;

    /** @var InventoryLocationRepositoryInterface */
    private $inventoryLocation;

    public function __construct(
        CreateInventoryLocationCommand $command,
        WarehouseRepositoryInterface $warehouseRepository,
        InventoryLocationRepositoryInterface $inventoryLocation
    ) {
        $this->command = $command;
        $this->warehouseRepository = $warehouseRepository;
        $this->inventoryLocation = $inventoryLocation;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $warehouse = $this->warehouseRepository->findOneById(
            $this->command->getWarehouseId()
        );

        $inventoryLocation = new InventoryLocation(
            $warehouse,
            $this->command->getName(),
            $this->command->getCode(),
            $this->command->getInventoryLocationId()
        );

        $this->inventoryLocation->create($inventoryLocation);
    }
}
