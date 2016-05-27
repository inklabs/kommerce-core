<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTaxRateRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class TaxRateServiceTest extends ServiceTestCase
{
    /** @var FakeTaxRateRepository */
    protected $taxRateRepository;

    /** @var TaxRateService */
    private $taxRateService;

    public function setUp()
    {
        parent::setUp();
        $this->taxRateRepository = new FakeTaxRateRepository;
        $this->taxRateService = new TaxRateService($this->taxRateRepository);
    }

    public function testCreate()
    {
        $taxRate = $this->dummyData->getTaxRate();
        $this->taxRateService->create($taxRate);
        $this->assertTrue($taxRate instanceof TaxRate);
    }

    public function testEdit()
    {
        $newState = 'XX';
        $taxRate = $this->dummyData->getTaxRate();
        $this->assertNotSame($newState, $taxRate->getState());

        $taxRate->setState($newState);
        $this->taxRateService->edit($taxRate);
        $this->assertSame($newState, $taxRate->getState());
    }

    public function testFind()
    {
        $taxRate = $this->dummyData->getTaxRate();
        $this->taxRateRepository->create($taxRate);

        $taxRate = $this->taxRateService->findOneById(1);
        $this->assertTrue($taxRate instanceof TaxRate);
    }

    public function testFindAll()
    {
        $taxRates = $this->taxRateService->findAll();
        $this->assertTrue($taxRates[0] instanceof TaxRate);
    }

    public function testFindByZip5AndStateWithZip5()
    {
        $taxRate = $this->taxRateService->findByZip5AndState('92606');
        $this->assertTrue($taxRate instanceof TaxRate);
    }
}
