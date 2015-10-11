<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\TaxRate;

/**
 * @method TaxRate findOneById($id)
 */
interface TaxRateRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return TaxRate[]
     */
    public function findAll();

    /**
     * @param string $zip5
     * @param string $state
     * @return TaxRate
     * @throws \LogicException
     */
    public function findByZip5AndState($zip5 = null, $state = null);
}
