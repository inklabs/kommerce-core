<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

interface TaxRateRepositoryInterface
{
    public function save(Entity\TaxRate & $taxRate);
    public function create(Entity\TaxRate & $taxRate);
    public function remove(Entity\TaxRate & $taxRate);

    /**
     * @param int $id
     * @return Entity\TaxRate
     */
    public function find($id);

    /**
     * @return Entity\TaxRate[]
     */
    public function findAll();

    /**
     * @param string $zip5
     * @param string $state
     * @return Entity\TaxRate
     * @throws \LogicException
     */
    public function findByZip5AndState($zip5 = null, $state = null);
}
