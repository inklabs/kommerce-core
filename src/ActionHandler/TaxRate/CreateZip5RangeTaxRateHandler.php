<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\CreateZip5RangeTaxRateCommand;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class CreateZip5RangeTaxRateHandler
{
    /** @var TaxRateServiceInterface */
    protected $taxRateService;

    public function __construct(TaxRateServiceInterface $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    public function handle(CreateZip5RangeTaxRateCommand $command)
    {
        $taxRate = TaxRate::createZip5Range(
            $command->getZip5From(),
            $command->getZip5To(),
            $command->getRate(),
            $command->applyToShipping()
        );

        $this->taxRateService->create($taxRate);
    }
}
