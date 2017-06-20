<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\ListTaxRatesQuery;
use inklabs\kommerce\ActionResponse\TaxRate\ListTaxRatesResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListTaxRatesHandler implements QueryHandlerInterface
{
    /** @var ListTaxRatesQuery */
    private $query;

    /** @var TaxRateRepositoryInterface */
    private $taxRateRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListTaxRatesQuery $query,
        TaxRateRepositoryInterface $taxRateRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->taxRateRepository = $taxRateRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new ListTaxRatesResponse();

        $taxRates = $this->taxRateRepository->findAll();

        foreach ($taxRates as $taxRate) {
            $response->addTaxRateDTOBuilder(
                $this->dtoBuilderFactory->getTaxRateDTOBuilder($taxRate)
            );
        }

        return $response;
    }
}
