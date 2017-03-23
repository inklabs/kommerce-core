<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\UpdateInventoryLocationCommand;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateInventoryLocationHandler implements CommandHandlerInterface
{
    /** @var UpdateInventoryLocationCommand */
    private $command;

    /** @var InventoryLocationRepositoryInterface */
    private $inventoryLocationRepository;

    public function __construct(
        UpdateInventoryLocationCommand $command,
        InventoryLocationRepositoryInterface $inventoryLocationRepository
    ) {
        $this->command = $command;
        $this->inventoryLocationRepository = $inventoryLocationRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $inventoryLocation = $this->inventoryLocationRepository->findOneById(
            $this->command->getInventoryLocationId()
        );

        $inventoryLocation->setName($this->command->getName());
        $inventoryLocation->setCode($this->command->getCode());

        $this->inventoryLocationRepository->update($inventoryLocation);
    }
}
