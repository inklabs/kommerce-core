<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetExternalShipmentRateCommand;
use inklabs\kommerce\Service\CartServiceInterface;

final class SetExternalShipmentRateHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(SetExternalShipmentRateCommand $command)
    {
        $this->cartService->setExternalShipmentRate(
            $command->getCartId(),
            $command->getShipmentRateExternalId(),
            $command->getShippingAddressDTO()
        );
    }
}
