<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\DeleteInventoryLocationCommand;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteInventoryLocationHandler implements CommandHandlerInterface
{
    /** @var DeleteInventoryLocationCommand */
    private $command;

    /** @var InventoryLocationRepositoryInterface */
    protected $inventoryLocationRepository;

    public function __construct(
        DeleteInventoryLocationCommand $command,
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
        $this->inventoryLocationRepository->delete($inventoryLocation);
    }
}
