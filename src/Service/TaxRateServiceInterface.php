<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\TaxRate;

interface TaxRateServiceInterface
{
    /**
     * @param string $zip5
     * @param string $state
     * @return TaxRate|null
     */
    public function findByZip5AndState($zip5 = null, $state = null);
}
