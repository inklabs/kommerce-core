<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Entity as Entity;

class TaxRateTest extends Helper\DoctrineTestCase
{
    /* @var TaxRate */
    private $taxRateService;

    /* @var Entity\TaxRate[] */
    private $taxRates;

    public function setUp()
    {
        $this->taxRates = [
            0 => $this->getTaxRate('CA', null, null, null, 7.5, true),
            1 => $this->getTaxRate(null, 92606, null, null, 8, true),
            2 => $this->getTaxRate(null, null, 92602, 92604, 8, true),
        ];

        foreach ($this->taxRates as $taxRate) {
            $this->entityManager->persist($taxRate);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        $this->taxRateService = new TaxRate($this->entityManager);
    }

    /**
     * @return Entity\TaxRate
     */
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
        $this->assertEquals(3, count($taxRates));
    }

    public function testFindByZip5AndStateWithZip5()
    {
        $taxRate = $this->taxRateService->findByZip5AndState('92606');
        $this->assertEquals(2, $taxRate->getId());
    }
}
