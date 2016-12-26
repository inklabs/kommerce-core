<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateStateTaxRateCommand;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class UpdateStateTaxRateHandler
{
    /** @var TaxRateServiceInterface */
    protected $taxRateService;

    public function __construct(TaxRateServiceInterface $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    public function handle(UpdateStateTaxRateCommand $command)
    {
        $taxRate = $this->taxRateService->findOneById($command->getTaxRateId());
        $taxRate->setState($command->getState());
        $taxRate->setRate($command->getRate());
        $taxRate->setApplyToShipping($command->applyToShipping());

        $this->taxRateService->update($taxRate);
    }
}
