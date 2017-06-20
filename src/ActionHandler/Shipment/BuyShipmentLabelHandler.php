<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\BuyShipmentLabelCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class BuyShipmentLabelHandler implements CommandHandlerInterface
{
    /** @var BuyShipmentLabelCommand */
    private $command;

    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(BuyShipmentLabelCommand $command, OrderServiceInterface $orderService)
    {
        $this->command = $command;
        $this->orderService = $orderService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $this->orderService->buyShipmentLabel(
            $this->command->getOrderId(),
            $this->command->getOrderItemQtyDTO(),
            $this->command->getComment(),
            $this->command->getRateExternalId(),
            $this->command->getShipmentExternalId()
        );
    }
}
