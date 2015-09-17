<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;

class TaxRate extends AbstractService
{
    /** @var TaxRateRepositoryInterface */
    private $taxRateRepository;

    public function __construct(TaxRateRepositoryInterface $taxRateRepository)
    {
        $this->taxRateRepository = $taxRateRepository;
    }

    public function create(Entity\TaxRate & $taxRate)
    {
        $this->throwValidationErrors($taxRate);
        $this->taxRateRepository->create($taxRate);
    }

    public function edit(Entity\TaxRate & $taxRate)
    {
        $this->throwValidationErrors($taxRate);
        $this->taxRateRepository->save($taxRate);
    }

    public function find($id)
    {
        return $this->taxRateRepository->find($id);
    }

    public function findAll()
    {
        return $this->taxRateRepository->findAll();
    }

    /**
     * @param string $zip5
     * @param string $state
     * @return Entity\TaxRate|null
     */
    public function findByZip5AndState($zip5 = null, $state = null)
    {
        return $this->taxRateRepository->findByZip5AndState($zip5, $state);
    }
}
