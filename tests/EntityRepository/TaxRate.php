<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class TaxRateTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:TaxRate',
    ];

    /** @var TaxRateInterface */
    protected $taxRateRepository;

    public function setUp()
    {
        $this->taxRateRepository = $this->entityManager->getRepository('kommerce:TaxRate');
    }

    private function setupTaxRates()
    {
        $taxRates = [
            0 => $this->getTaxRate('CA', null, null, null, 7.5, true),
            1 => $this->getTaxRate(null, 92606, null, null, 8, true),
            2 => $this->getTaxRate(null, null, 92602, 92604, 8, true),
        ];

        foreach ($taxRates as $taxRate) {
            $this->entityManager->persist($taxRate);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $taxRates;
    }

    private function getTaxRate($state, $zip5, $zip5From, $zip5To, $rate, $applyToShipping)
    {
        $taxRate = new Entity\TaxRate;
        $taxRate->setState($state);
        $taxRate->setZip5($zip5);
        $taxRate->setZip5From($zip5From);
        $taxRate->setZip5To($zip5To);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);

        return $taxRate;
    }

    public function testFindAll()
    {
        $this->setupTaxRates();

        $taxRates = $this->taxRateRepository->findAll();
        $this->assertSame(3, count($taxRates));
    }

    /**
     * @expectedException \LogicException
     */
    public function testFindByZip5AndStateEmpty()
    {
        $this->setupTaxRates();

        $this->taxRateRepository->findByZip5AndState();
    }

    public function testFindByZip5AndStateWithZip5()
    {
        $this->setupTaxRates();

        $taxRate = $this->taxRateRepository->findByZip5AndState('92606');
        $this->assertSame(2, $taxRate->getId());
    }

    public function testFindByZip5AndStateWithZip5Ranged()
    {
        $this->setupTaxRates();

        $taxRate = $this->taxRateRepository->findByZip5AndState('92603');
        $this->assertSame(3, $taxRate->getId());
    }

    public function testFindByZip5AndStateWithState()
    {
        $this->setupTaxRates();

        $taxRate = $this->taxRateRepository->findByZip5AndState(null, 'CA');
        $this->assertSame(1, $taxRate->getId());
    }

    public function testFindByZip5AndStateWithZip5AndState()
    {
        $this->setupTaxRates();

        $taxRate = $this->taxRateRepository->findByZip5AndState('92606', 'CA');
        $this->assertSame(2, $taxRate->getId());
    }

    public function testFindByZip5AndStateMissing()
    {
        $this->setupTaxRates();

        $taxRate = $this->taxRateRepository->findByZip5AndState('11111');
        $this->assertSame(null, $taxRate);
    }
}
