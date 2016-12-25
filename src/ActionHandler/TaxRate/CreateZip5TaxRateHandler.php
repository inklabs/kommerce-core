<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateZip5TaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class CreateZip5TaxRateHandler
{
    /** @var TaxRateServiceInterface */
    protected $taxRateService;

    public function __construct(TaxRateServiceInterface $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    public function handle(CreateZip5TaxRateCommand $command)
    {
        $taxRate = TaxRate::createZip5(
            $command->getZip5(),
            $command->getRate(),
            $command->applyToShipping()
        );

        $this->taxRateService->create($taxRate);
    }
}
