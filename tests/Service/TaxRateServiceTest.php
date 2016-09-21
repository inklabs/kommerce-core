<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTaxRateRepository;
use inklabs\kommerce\tests\Helper\TestCase\ServiceTestCase;

class TaxRateServiceTest extends ServiceTestCase
{
    /** @var TaxRateRepositoryInterface|\Mockery\Mock */
    protected $taxRateRepository;

    /** @var TaxRateService */
    private $taxRateService;

    public function setUp()
    {
        parent::setUp();
        $this->taxRateRepository = $this->mockRepository->getTaxRateRepository();
        $this->taxRateService = new TaxRateService($this->taxRateRepository);
    }

    public function testCRUD()
    {
        $this->executeServiceCRUD(
            $this->taxRateService,
            $this->taxRateRepository,
            $this->dummyData->getTaxRate()
        );
    }

    public function testFind()
    {
        $taxRate1 = $this->dummyData->getTaxRate();
        $this->taxRateRepository->shouldReceive('findOneById')
            ->with($taxRate1->getId())
            ->andReturn($taxRate1)
            ->once();

        $taxRate = $this->taxRateService->findOneById(
            $taxRate1->getId()
        );

        $this->assertEntitiesEqual($taxRate1, $taxRate);
    }

    public function testFindAll()
    {
        $taxRate1 = $this->dummyData->getTaxRate();
        $this->taxRateRepository->shouldReceive('findAll')
            ->andReturn([$taxRate1])
            ->once();

        $taxRates = $this->taxRateService->findAll();

        $this->assertEntitiesEqual($taxRate1, $taxRates[0]);
    }

    public function testFindByZip5AndStateWithZip5()
    {
        $taxRate1 = $this->dummyData->getTaxRate();
        $this->taxRateRepository->shouldReceive('findByZip5AndState')
            ->with($taxRate1->getZip5(), null)
            ->andReturn($taxRate1)
            ->once();

        $taxRate = $this->taxRateService->findByZip5AndState(
            $taxRate1->getZip5()
        );

        $this->assertEntitiesEqual($taxRate1, $taxRate);
    }
}
