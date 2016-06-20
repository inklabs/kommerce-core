<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartFlatRateShipmentRateCommand;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Service\CartServiceInterface;

final class SetCartFlatRateShipmentRateHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(SetCartFlatRateShipmentRateCommand $command)
    {
        $moneyDTO = $command->getMoneyDTO();
        $shipmentRate = new ShipmentRate(new Money(
            $moneyDTO->amount,
            $moneyDTO->currency
        ));

        $this->cartService->setShipmentRate(
            $command->getCartId(),
            $shipmentRate
        );
    }
}
