<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use Doctrine as Doctrine;

class TaxRate extends Lib\EntityManager
{
    public function __construct(Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function findAll()
    {
        return $this->entityManager->getRepository('inklabs\kommerce\Entity\TaxRate')->findAll();
    }

    public function findByZip5AndState($zip5 = null, $state = null)
    {
        $qb = $this->createQueryBuilder();

        $query = $qb->select('tax_rate')
            ->from('inklabs\kommerce\Entity\TaxRate', 'tax_rate');

        if ($state !== null) {
            $query = $query
                ->where('tax_rate.state = :state')
                ->setParameter('state', $state);
        }

        if ($zip5 !== null) {
            $query = $query
                ->orWhere('tax_rate.zip5 = :zip5')
                ->orWhere('tax_rate.zip5From <= :zip5 AND tax_rate.zip5To >= :zip5')
                ->orderBy('tax_rate.id')
                ->setParameter('zip5', $zip5);
        }

        $taxRates = $query->findAll();

        $viewTaxRates = [];
        foreach ($taxRates as $taxRate) {
            $viewTaxRates[] = Entity\View\TaxRate::factory($taxRate);
        }

        return $viewTaxRates;
    }
}
