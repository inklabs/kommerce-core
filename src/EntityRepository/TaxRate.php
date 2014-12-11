<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

class TaxRate extends EntityRepository
{
    /**
     * @return Entity\TaxRate[]
     * @throws \LogicException
     */
    public function findByZip5AndState($zip5 = null, $state = null)
    {
        if ($zip5 === null and $state === null) {
            throw new \LogicException('Invalid zip5 or state');
        }

        $qb = $this->getQueryBuilder();

        $query = $qb->select('tax_rate')
            ->from('kommerce:TaxRate', 'tax_rate');

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

        return $this->getZip5OrRateOrStateTaxRate($taxRates);
    }

    /**
     * @param Entity\TaxRate[] $taxRates
     * @return Entity\TaxRate
     */
    protected function getZip5OrRateOrStateTaxRate(array $taxRates)
    {
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

        if (!empty($zip5TaxRates)) {
            $taxRate = $zip5TaxRates[0];
        } elseif (!empty($RangeTaxRates)) {
            $taxRate = $RangeTaxRates[0];
        } elseif (!empty($stateTaxRates)) {
            $taxRate = $stateTaxRates[0];
        } else {
            return null;
        }

        return $taxRate;
    }
}
