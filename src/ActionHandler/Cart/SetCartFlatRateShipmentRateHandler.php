<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartFlatRateShipmentRateCommand;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class SetCartFlatRateShipmentRateHandler implements CommandHandlerInterface
{
    /** @var SetCartFlatRateShipmentRateCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    public function __construct(
        SetCartFlatRateShipmentRateCommand $command,
        CartRepositoryInterface $cartRepository
    ) {
        $this->command = $command;
        $this->cartRepository = $cartRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $moneyDTO = $this->command->getMoneyDTO();
        $shipmentRate = new ShipmentRate(new Money(
            $moneyDTO->amount,
            $moneyDTO->currency
        ));

        $cart = $this->cartRepository->findOneById($this->command->getCartId());
        $cart->setShipmentRate($shipmentRate);
        $this->cartRepository->update($cart);
    }
}
