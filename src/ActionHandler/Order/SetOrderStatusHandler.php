<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\SetOrderStatusCommand;
use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class SetOrderStatusHandler implements CommandHandlerInterface
{
    /** @var SetOrderStatusCommand */
    private $command;

    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(
        SetOrderStatusCommand $command,
        OrderServiceInterface $orderService
    ) {
        $this->command = $command;
        $this->orderService = $orderService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $this->orderService->setOrderStatus(
            $this->command->getOrderId(),
            OrderStatusType::createById($this->command->getOrderStatusTypeId())
        );
    }
}
