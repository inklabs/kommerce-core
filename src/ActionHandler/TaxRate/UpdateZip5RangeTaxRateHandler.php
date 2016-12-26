<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\UpdateZip5RangeTaxRateCommand;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class UpdateZip5RangeTaxRateHandler
{
    /** @var TaxRateServiceInterface */
    protected $taxRateService;

    public function __construct(TaxRateServiceInterface $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    public function handle(UpdateZip5RangeTaxRateCommand $command)
    {
        $taxRate = $this->taxRateService->findOneById($command->getTaxRateId());
        $taxRate->setZip5From($command->getZip5From());
        $taxRate->setZip5To($command->getZip5To());
        $taxRate->setRate($command->getRate());
        $taxRate->setApplyToShipping($command->applyToShipping());

        $this->taxRateService->update($taxRate);
    }
}
