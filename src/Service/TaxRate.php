<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use Doctrine;

class TaxRate extends Lib\ServiceManager
{
    /** @var EntityRepository\TaxRateInterface */
    private $taxRateRepository;

    public function __construct(EntityRepository\TaxRateInterface $taxRateRepository)
    {
        $this->taxRateRepository = $taxRateRepository;
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
