<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartTaxRateByZip5AndStateCommand;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class SetCartTaxRateByZip5AndStateHandler
{
    /** @var CartServiceInterface */
    private $cartService;

    /** @var TaxRateServiceInterface */
    private $taxRateService;

    public function __construct(CartServiceInterface $cartService, TaxRateServiceInterface $taxRateService)
    {
        $this->cartService = $cartService;
        $this->taxRateService = $taxRateService;
    }

    public function handle(SetCartTaxRateByZip5AndStateCommand $command)
    {
        $taxRate = $this->taxRateService->findByZip5AndState(
            $command->getZip5(),
            $command->getState()
        );

        $this->cartService->setTaxRate(
            $command->getCartId(),
            $taxRate
        );
    }
}
