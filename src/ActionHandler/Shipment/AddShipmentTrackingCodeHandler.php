<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Shipment\AddShipmentTrackingCodeCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\OrderServiceInterface;

final class AddShipmentTrackingCodeHandler implements CommandHandlerInterface
{
    /** @var AddShipmentTrackingCodeCommand */
    private $command;

    /** @var OrderServiceInterface */
    private $orderService;

    public function __construct(AddShipmentTrackingCodeCommand $command, OrderServiceInterface $orderService)
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
        $this->orderService->addShipmentTrackingCode(
            $this->command->getOrderId(),
            $this->command->getOrderItemQtyDTO(),
            $this->command->getComment(),
            $this->command->getCarrier(),
            $this->command->getTrackingCode()
        );
    }
}
