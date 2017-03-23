<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\CreateInventoryLocationCommand;
use inklabs\kommerce\Entity\InventoryLocation;
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
    private $inventoryLocationRepository;

    public function __construct(
        CreateInventoryLocationCommand $command,
        WarehouseRepositoryInterface $warehouseRepository,
        InventoryLocationRepositoryInterface $inventoryLocationRepository
    ) {
        $this->command = $command;
        $this->warehouseRepository = $warehouseRepository;
        $this->inventoryLocationRepository = $inventoryLocationRepository;
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

        $this->inventoryLocationRepository->create($inventoryLocation);
    }
}
