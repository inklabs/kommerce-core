<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5TaxRateCommand;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class UpdateZip5TaxRateHandler
{
    /** @var TaxRateServiceInterface */
    protected $taxRateService;

    public function __construct(TaxRateServiceInterface $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    public function handle(UpdateZip5TaxRateCommand $command)
    {
        $taxRate = $this->taxRateService->findOneById($command->getTaxRateId());
        $taxRate->setZip5($command->getZip5());
        $taxRate->setRate($command->getRate());
        $taxRate->setApplyToShipping($command->applyToShipping());

        $this->taxRateService->update($taxRate);
    }
}
