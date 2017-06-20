<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\DeleteWarehouseCommand;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteWarehouseHandler implements CommandHandlerInterface
{
    /** @var DeleteWarehouseCommand */
    private $command;

    /** @var WarehouseRepositoryInterface */
    protected $warehouseRepository;

    public function __construct(DeleteWarehouseCommand $command, WarehouseRepositoryInterface $warehouseRepository)
    {
        $this->command = $command;
        $this->warehouseRepository = $warehouseRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $warehouse = $this->warehouseRepository->findOneById($this->command->getWarehouseId());
        $this->warehouseRepository->delete($warehouse);
    }
}
