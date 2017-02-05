<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetExternalShipmentRateCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\CartServiceInterface;

final class SetExternalShipmentRateHandler implements CommandHandlerInterface
{
    /** @var SetExternalShipmentRateCommand */
    private $command;

    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(
        SetExternalShipmentRateCommand $command,
        CartServiceInterface $cartService
    ) {
        $this->command = $command;
        $this->cartService = $cartService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $this->cartService->setExternalShipmentRate(
            $this->command->getCartId(),
            $this->command->getShipmentRateExternalId(),
            $this->command->getShippingAddressDTO()
        );
    }
}
