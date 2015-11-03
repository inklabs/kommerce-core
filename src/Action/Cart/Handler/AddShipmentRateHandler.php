<?php
namespace inklabs\kommerce\Action\Cart\Handler;

use inklabs\kommerce\Action\Cart\AddShipmentRateCommand;
use inklabs\kommerce\Service\CartServiceInterface;

class AddShipmentRateHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(AddShipmentRateCommand $command)
    {
        $this->cartService->setShipmentRate(
            $command->getCartId(),
            $command->getShipmentRateExternalId(),
            $command->getShippingAddressDTO()
        );
    }
}
