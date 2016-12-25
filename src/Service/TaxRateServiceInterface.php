<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Lib\UuidInterface;

interface TaxRateServiceInterface
{
    public function create(TaxRate & $taxRate);
    public function update(TaxRate & $taxRate);

    /**
     * @param TaxRate $taxRate
     */
    public function delete(TaxRate $taxRate);

    /**
     * @param UuidInterface $id
     * @return TaxRate
     */
    public function findOneById(UuidInterface $id);

    /**
     * @return TaxRate[]
     */
    public function findAll();

    /**
     * @param string $zip5
     * @param string $state
     * @return TaxRate|null
     */
    public function findByZip5AndState($zip5 = null, $state = null);
}
