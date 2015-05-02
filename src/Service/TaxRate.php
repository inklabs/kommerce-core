<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use Doctrine;

class TaxRate extends AbstractService
{
    /** @var EntityRepository\TaxRateInterface */
    private $taxRateRepository;

    public function __construct(EntityRepository\TaxRateInterface $taxRateRepository)
    {
        $this->taxRateRepository = $taxRateRepository;
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
     * @return Entity\TaxRate|null
     * @throws \LogicException
     */
    public function findByZip5AndState($zip5 = null, $state = null)
    {
        return $this->taxRateRepository->findByZip5AndState($zip5, $state);
    }
}
