<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class WarehouseRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
    ];
    protected $santaMonicaPoint;
    protected $losAngelesPoint;
    const RANGE_IN_MILES_SMALL = 1;
    const RANGE_IN_MILES_LONG = 50;

    /** @var WarehouseRepositoryInterface */
    protected $warehouseRepository;

    public function setUp()
    {
        parent::setUp();
        $this->warehouseRepository = $this->getRepositoryFactory()->getWarehouseRepository();
        $this->losAngelesPoint = new Point(34.052234, -118.243685);
        $this->santaMonicaPoint = new Point(34.010947, -118.490541);
    }

    private function setupWarehouse()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $warehouse->getAddress()->setPoint($this->santaMonicaPoint);

        $this->warehouseRepository->create($warehouse);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $warehouse;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->warehouseRepository,
            $this->dummyData->getWarehouse()
        );
    }

    public function testFindOneById()
    {
        $originalWarehouse = $this->setupWarehouse();
        $this->setCountLogger();

        $warehouse = $this->warehouseRepository->findOneById(
            $originalWarehouse->getId()
        );

        $this->assertEqualEntities($originalWarehouse, $warehouse);
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Warehouse not found'
        );

        $this->warehouseRepository->findOneById(
            $this->dummyData->getId()
        );
    }

    public function testFindByPointNotInRange()
    {
        $this->setupWarehouse();
        $warehouses = $this->warehouseRepository->findByPoint(
            $this->losAngelesPoint,
            self::RANGE_IN_MILES_SMALL
        );

        $this->assertSame(0, count($warehouses));
    }

    public function testFindByPoint()
    {
        $originalWarehouse = $this->setupWarehouse();

        $warehouses = $this->warehouseRepository->findByPoint(
            $this->losAngelesPoint,
            self::RANGE_IN_MILES_LONG
        );

        $warehouse = $warehouses[0][0];
        $distance = $warehouses[0]['distance'];

        $this->assertEqualEntities($originalWarehouse, $warehouse);
        $this->assertEquals(14.421, $distance, null, FLOAT_DELTA);
    }
}
