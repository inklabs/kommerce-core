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
        if ($zip5 === null and $state === null) {
            throw new \Exception('Invalid zip5 or state');
        }

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
                ->setParameter('zip5', $zip5);
        }

        $taxRates = $query
            ->orderBy('tax_rate.id')
            ->findAll();

        $stateTaxRates = $zip5TaxRates = $RangeTaxRates = [];

        foreach ($taxRates as $taxRate) {
            if ($taxRate->getState() !== null) {
                $stateTaxRates[] = $taxRate;
            } elseif ($taxRate->getZip5() !== null) {
                $zip5TaxRates[] = $taxRate;
            } elseif ($taxRate->getZip5From() !== null) {
                $RangeTaxRates[] = $taxRate;
            }
        }
        unset($taxRates);

        if (! empty($zip5TaxRates)) {
            $taxRate = $zip5TaxRates[0];
        } elseif (! empty($RangeTaxRates)) {
            $taxRate = $RangeTaxRates[0];
        } elseif (! empty($stateTaxRates)) {
            $taxRate = $stateTaxRates[0];
        } else {
            return null;
        }

        return Entity\View\TaxRate::factory($taxRate);
    }
}
