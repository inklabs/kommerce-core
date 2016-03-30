<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Point;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper;

class WarehouseRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
    ];

    /** @var WarehouseRepositoryInterface */
    protected $warehouseRepository;

    public function setUp()
    {
        parent::setUp();
        $this->warehouseRepository = $this->getRepositoryFactory()->getWarehouseRepository();
    }

    private function setupWarehouse()
    {
        $warehouse = $this->dummyData->getWarehouse();

        $this->warehouseRepository->create($warehouse);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $warehouse;
    }

    public function testCRUD()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $this->warehouseRepository->create($warehouse);
        $this->assertSame(1, $warehouse->getid());

        $warehouse->setName('New Name');
        $this->assertSame(null, $warehouse->getUpdated());

        $this->warehouseRepository->update($warehouse);
        $this->assertTrue($warehouse->getUpdated() instanceof DateTime);

        $this->warehouseRepository->delete($warehouse);
        $this->assertSame(null, $warehouse->getId());
    }

    public function testFindOneById()
    {
        $this->setupWarehouse();

        $this->setCountLogger();

        $warehouse = $this->warehouseRepository->findOneById(1);

        $this->assertTrue($warehouse instanceof Warehouse);
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Warehouse not found'
        );

        $this->warehouseRepository->findOneById(1);
    }

    public function testFindByPointNotInRange()
    {
        $this->setupWarehouse();

        $losAngeles = new Point(34.052234, -118.243685);

        $warehouses = $this->warehouseRepository->findByPoint($losAngeles, 1);

        $this->assertSame(0, count($warehouses));
    }

    public function testFindByPoint()
    {
        $this->setupWarehouse();

        $losAngeles = new Point(34.052234, -118.243685);

        $warehouses = $this->warehouseRepository->findByPoint($losAngeles, 50);

        $warehouse = $warehouses[0][0];
        $distance = $warehouses[0]['distance'];

        $this->assertTrue($warehouse instanceof Warehouse);

        $this->assertEquals(14.421, $distance, null, FLOAT_DELTA);
    }
}
