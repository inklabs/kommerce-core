<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\CreateWarehouseCommand;
use inklabs\kommerce\Entity\Address;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateWarehouseHandler implements CommandHandlerInterface
{
    use UpdateWarehouseFromCommandTrait;

    /** @var CreateWarehouseCommand */
    private $command;

    /** @var WarehouseRepositoryInterface */
    private $couponRepository;

    public function __construct(
        CreateWarehouseCommand $command,
        WarehouseRepositoryInterface $couponRepository
    ) {
        $this->couponRepository = $couponRepository;
        $this->command = $command;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $coupon = new Warehouse(
            $this->command->getName(),
            new Address(),
            $this->command->getWarehouseId()
        );

        $this->updateWarehouseFromCommand($coupon, $this->command);

        $this->couponRepository->create($coupon);
    }
}
