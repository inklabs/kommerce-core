<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Entity as Entity;

class TaxRateTest extends Helper\DoctrineTestCase
{
    private $taxRateService;
    private $taxRates;

    public function setUp()
    {
        $this->taxRates = [
            $this->getTaxRate('CA', null, null, null, 7.5, true),
            $this->getTaxRate(null, 92606, null, null, 8, true),
            $this->getTaxRate(null, 92612, null, null, 8, true),
            $this->getTaxRate(null, null, 92602, 92604, 8, true),
        ];

        foreach ($this->taxRates as $taxRate) {
            $this->entityManager->persist($taxRate);
        }
        $this->entityManager->flush();

        $this->taxRateService = new TaxRate($this->entityManager);
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
        $taxRates = $this->taxRateService->findAll();
        $this->assertEquals($this->taxRates, $taxRates);
    }

    public function testFindByZip5AndStateEmpty()
    {
        $taxRates = $this->taxRateService->findByZip5AndState();
        $this->assertEquals(4, count($taxRates));
        $this->assertEquals(7.5, $taxRates[0]->rate);
    }

    public function testFindByZip5AndStateWithZip5()
    {
        $taxRates = $this->taxRateService->findByZip5AndState('92606');
        $this->assertEquals(1, count($taxRates));
        $this->assertEquals(8, $taxRates[0]->rate);
    }

    public function testFindByZip5AndStateWithState()
    {
        $taxRates = $this->taxRateService->findByZip5AndState(null, 'CA');
        $this->assertEquals(1, count($taxRates));
        $this->assertEquals(7.5, $taxRates[0]->rate);
    }

    public function testFindByZip5AndStateWithZip5AndState()
    {
        $taxRates = $this->taxRateService->findByZip5AndState('92606', 'CA');
        $this->assertEquals(2, count($taxRates));
        $this->assertEquals(7.5, $taxRates[0]->rate);
    }
}
