<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\UpdateWarehouseCommand;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateWarehouseHandler implements CommandHandlerInterface
{
    use UpdateWarehouseFromCommandTrait;

    /** @var UpdateWarehouseCommand */
    private $command;

    /** @var WarehouseRepositoryInterface */
    private $couponRepository;

    public function __construct(
        UpdateWarehouseCommand $command,
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
        $coupon = $this->couponRepository->findOneById(
            $this->command->getWarehouseId()
        );

        $this->updateWarehouseFromCommand($coupon, $this->command);

        $this->couponRepository->update($coupon);
    }
}
