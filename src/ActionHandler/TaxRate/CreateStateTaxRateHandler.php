<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateStateTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class CreateStateTaxRateHandler
{
    /** @var TaxRateServiceInterface */
    protected $taxRateService;

    public function __construct(TaxRateServiceInterface $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    public function handle(CreateStateTaxRateCommand $command)
    {
        $taxRate = TaxRate::createState(
            $command->getState(),
            $command->getRate(),
            $command->applyToShipping()
        );

        $this->taxRateService->create($taxRate);
    }
}
