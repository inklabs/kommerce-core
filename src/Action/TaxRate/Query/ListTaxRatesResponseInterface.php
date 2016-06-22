<?php
namespace inklabs\kommerce\Action\TaxRate\Query;

use inklabs\kommerce\EntityDTO\Builder\TaxRateDTOBuilder;

interface ListTaxRatesResponseInterface
{
    public function addTaxRateDTOBuilder(TaxRateDTOBuilder $taxRateDTOBuilder);
}
