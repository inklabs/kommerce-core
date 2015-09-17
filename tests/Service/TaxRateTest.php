<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeRepositoryTaxRate;

class TaxRateTest extends Helper\DoctrineTestCase
{
    /** @var FakeRepositoryTaxRate */
    protected $taxRateRepository;

    /** @var TaxRate */
    private $taxRateService;

    public function setUp()
    {
        $this->taxRateRepository = new FakeRepositoryTaxRate;
        $this->taxRateService = new TaxRate($this->taxRateRepository);
    }

    public function testCreate()
    {
        $taxRate = $this->getDummyTaxRate();
        $this->taxRateService->create($taxRate);
        $this->assertTrue($taxRate instanceof Entity\TaxRate);
    }

    public function testEdit()
    {
        $newState = 'XX';
        $taxRate = $this->getDummyTaxRate();
        $this->assertNotSame($newState, $taxRate->getState());

        $taxRate->setState($newState);
        $this->taxRateService->edit($taxRate);
        $this->assertSame($newState, $taxRate->getState());
    }

    public function testFind()
    {
        $taxRate = $this->taxRateService->find(1);
        $this->assertTrue($taxRate instanceof Entity\TaxRate);
    }

    public function testFindMissing()
    {
        $this->taxRateRepository->setReturnValue(null);

        $taxRate = $this->taxRateService->find(1);
        $this->assertSame(null, $taxRate);
    }

    public function testFindAll()
    {
        $taxRates = $this->taxRateService->findAll();
        $this->assertTrue($taxRates[0] instanceof Entity\TaxRate);
    }

    public function testFindByZip5AndStateWithZip5()
    {
        $taxRate = $this->taxRateService->findByZip5AndState('92606');
        $this->assertTrue($taxRate instanceof Entity\TaxRate);
    }
}
