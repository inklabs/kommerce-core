<?php
namespace inklabs\kommerce\ActionHandler\TaxRate;

use inklabs\kommerce\Action\TaxRate\ListTaxRatesQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\TaxRateServiceInterface;

final class ListTaxRatesHandler
{
    /** @var TaxRateServiceInterface */
    private $tagService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(TaxRateServiceInterface $tagService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->tagService = $tagService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListTaxRatesQuery $query)
    {
        $tags = $this->tagService->findAll();

        foreach ($tags as $tag) {
            $query->getResponse()->addTaxRateDTOBuilder(
                $this->dtoBuilderFactory->getTaxRateDTOBuilder($tag)
            );
        }
    }
}
