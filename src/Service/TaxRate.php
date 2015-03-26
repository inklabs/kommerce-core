<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use Doctrine as Doctrine;

class TaxRate extends Lib\ServiceManager
{

    /** @var EntityRepository\TaxRate */
    private $taxRateRepository;

    public function __construct(Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->taxRateRepository = $entityManager->getRepository('kommerce:TaxRate');
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
