<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\ListTaxRatesQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class ListTaxRatesHandler
{
    /** @var TaxRateServiceInterface */
    private $taxRateService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(TaxRateServiceInterface $taxRateService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->taxRateService = $taxRateService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListTaxRatesQuery $query)
    {
        $request = $query->getRequest();

        $taxRates = $this->taxRateService->findAll();

        foreach ($taxRates as $taxRate) {
            $query->getResponse()->addTaxRateDTOBuilder(
                $this->dtoBuilderFactory->getTaxRateDTOBuilder($taxRate)
            );
        }
    }
}
