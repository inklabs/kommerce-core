<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\DeleteTaxRateCommand;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class DeleteTaxRateHandler
{
    /** @var TaxRateServiceInterface */
    protected $taxRateService;

    public function __construct(TaxRateServiceInterface $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    public function handle(DeleteTaxRateCommand $command)
    {
        $taxRate = $this->taxRateService->findOneById($command->getTaxRateId());
        $this->taxRateService->delete($taxRate);
    }
}
