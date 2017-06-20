<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartTaxRateByZip5AndStateCommand;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class SetCartTaxRateByZip5AndStateHandler implements CommandHandlerInterface
{
    /** @var SetCartTaxRateByZip5AndStateCommand */
    private $command;

    /** @var CartRepositoryInterface */
    private $cartRepository;

    /** @var TaxRateRepositoryInterface */
    private $taxRateRepository;

    public function __construct(
        SetCartTaxRateByZip5AndStateCommand $command,
        CartRepositoryInterface $cartRepository,
        TaxRateRepositoryInterface $taxRateRepository
    ) {
        $this->command = $command;
        $this->cartRepository = $cartRepository;
        $this->taxRateRepository = $taxRateRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanManageCart($this->command->getCartId());
    }

    public function handle()
    {
        $taxRate = $this->taxRateRepository->findByZip5AndState(
            $this->command->getZip5(),
            $this->command->getState()
        );

        $cart = $this->cartRepository->findOneById($this->command->getCartId());
        $cart->setTaxRate($taxRate);

        $this->cartRepository->update($cart);
    }
}
