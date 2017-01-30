<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\ListTaxRatesQuery;
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

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $taxRates = $this->taxRateRepository->findAll();

        foreach ($taxRates as $taxRate) {
            $this->query->getResponse()->addTaxRateDTOBuilder(
                $this->dtoBuilderFactory->getTaxRateDTOBuilder($taxRate)
            );
        }
    }
}
