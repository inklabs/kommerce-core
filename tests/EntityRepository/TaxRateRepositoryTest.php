<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class TaxRateRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        TaxRate::class,
    ];

    /** @var TaxRateRepositoryInterface */
    protected $taxRateRepository;

    /** @var TaxRate[] */
    private $taxRates;

    public function setUp()
    {
        parent::setUp();
        $this->taxRateRepository = $this->getRepositoryFactory()->getTaxRateRepository();
        $this->setupTaxRates();
    }

    private function setupTaxRates()
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

        return $this->taxRates;
    }

    private function getTaxRate($state, $zip5, $zip5From, $zip5To, $rate, $applyToShipping)
    {
        $taxRate = new TaxRate;
        $taxRate->setState($state);
        $taxRate->setZip5($zip5);
        $taxRate->setZip5From($zip5From);
        $taxRate->setZip5To($zip5To);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);

        return $taxRate;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->taxRateRepository,
            $this->dummyData->getTaxRate()
        );
    }

    public function testFindAll()
    {
        $taxRates = $this->taxRateRepository->findAll();
        $this->assertSame(3, count($taxRates));
    }

    public function testFindByZip5AndStateEmptyThrowsException()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            'Missing zip5 or state'
        );

        $this->taxRateRepository->findByZip5AndState();
    }

    public function testFindByZip5AndStateWithZip5()
    {
        $taxRate = $this->taxRateRepository->findByZip5AndState('92606');
        $this->assertEntitiesEqual($this->taxRates[1], $taxRate);
    }

    public function testFindByZip5AndStateWithZip5Ranged()
    {
        $taxRate = $this->taxRateRepository->findByZip5AndState('92603');
        $this->assertEntitiesEqual($this->taxRates[2], $taxRate);
    }

    public function testFindByZip5AndStateWithState()
    {
        $taxRate = $this->taxRateRepository->findByZip5AndState(null, 'CA');
        $this->assertEntitiesEqual($this->taxRates[0], $taxRate);
    }

    public function testFindByZip5AndStateWithZip5AndState()
    {
        $taxRate = $this->taxRateRepository->findByZip5AndState('92606', 'CA');
        $this->assertEntitiesEqual($this->taxRates[1], $taxRate);
    }

    public function testFindByZip5AndStateMissing()
    {
        $taxRate = $this->taxRateRepository->findByZip5AndState('11111');
        $this->assertSame(null, $taxRate);
    }
}
