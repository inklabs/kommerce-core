<?php
namespace inklabs\kommerce\ActionResponse\TaxRate;

use inklabs\kommerce\EntityDTO\Builder\TaxRateDTOBuilder;
use inklabs\kommerce\EntityDTO\TaxRateDTO;

class ListTaxRatesResponse
{
    /** @var TaxRateDTOBuilder[] */
    private $tagDTOBuilders = [];

    public function addTaxRateDTOBuilder(TaxRateDTOBuilder $tagDTOBuilder)
    {
        $this->tagDTOBuilders[] = $tagDTOBuilder;
    }

    /**
     * @return TaxRateDTO[]
     */
    public function getTaxRateDTOs()
    {
        $tagDTOs = [];
        foreach ($this->tagDTOBuilders as $tagDTOBuilder) {
            $tagDTOs[] = $tagDTOBuilder->build();
        }
        return $tagDTOs;
    }
}
