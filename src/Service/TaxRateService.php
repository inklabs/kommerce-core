<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class TaxRateService
{
    use EntityValidationTrait;

    /** @var TaxRateRepositoryInterface */
    private $taxRateRepository;

    public function __construct(TaxRateRepositoryInterface $taxRateRepository)
    {
        $this->taxRateRepository = $taxRateRepository;
    }

    public function create(TaxRate & $taxRate)
    {
        $this->throwValidationErrors($taxRate);
        $this->taxRateRepository->create($taxRate);
    }

    public function update(TaxRate & $taxRate)
    {
        $this->throwValidationErrors($taxRate);
        $this->taxRateRepository->update($taxRate);
    }

    public function findOneById(UuidInterface $id)
    {
        return $this->taxRateRepository->findOneById($id);
    }

    public function findAll()
    {
        return $this->taxRateRepository->findAll();
    }

    /**
     * @param string $zip5
     * @param string $state
     * @return TaxRate|null
     */
    public function findByZip5AndState($zip5 = null, $state = null)
    {
        return $this->taxRateRepository->findByZip5AndState($zip5, $state);
    }
}
