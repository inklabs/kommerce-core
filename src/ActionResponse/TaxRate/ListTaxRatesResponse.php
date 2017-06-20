<?php
namespace inklabs\kommerce\ActionResponse\TaxRate;

use inklabs\kommerce\EntityDTO\Builder\TaxRateDTOBuilder;
use inklabs\kommerce\EntityDTO\TaxRateDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListTaxRatesResponse implements ResponseInterface
{
    /** @var TaxRateDTOBuilder[] */
    private $tagDTOBuilders = [];

    public function addTaxRateDTOBuilder(TaxRateDTOBuilder $tagDTOBuilder): void
    {
        $this->tagDTOBuilders[] = $tagDTOBuilder;
    }

    /**
     * @return TaxRateDTO[]
     */
    public function getTaxRateDTOs(): array
    {
        $tagDTOs = [];
        foreach ($this->tagDTOBuilders as $tagDTOBuilder) {
            $tagDTOs[] = $tagDTOBuilder->build();
        }
        return $tagDTOs;
    }
}
