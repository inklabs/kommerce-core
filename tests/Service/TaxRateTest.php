<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\tests\Helper;
use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTaxRate;

class TaxRateTest extends Helper\DoctrineTestCase
{
    /** @var FakeTaxRate */
    protected $taxRateRepository;

    /** @var TaxRate */
    private $taxRateService;

    public function setUp()
    {
        $this->taxRateRepository = new FakeTaxRate;
        $this->taxRateService = new TaxRate($this->taxRateRepository);
    }

    public function testFind()
    {
        $product = $this->taxRateService->find(1);
        $this->assertTrue($product instanceof Entity\TaxRate);
    }

    public function testFindMissing()
    {
        $this->taxRateRepository->setReturnValue(null);

        $product = $this->taxRateService->find(1);
        $this->assertSame(null, $product);
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
