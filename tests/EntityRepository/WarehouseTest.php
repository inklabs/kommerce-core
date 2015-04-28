<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class WarehouseTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Warehouse',
    ];

    /** @var WarehouseInterface */
    protected $warehouseRepository;

    public function setUp()
    {
        $this->warehouseRepository = $this->entityManager->getRepository('kommerce:Warehouse');
    }

    private function setupWarehouse()
    {
        $warehouse = $this->getDummyWarehouse();

        $this->entityManager->persist($warehouse);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupWarehouse();

        $this->setCountLogger();

        $warehouse = $this->warehouseRepository->find(1);

        $this->assertTrue($warehouse instanceof Entity\Warehouse);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testFindByPointNotInRange()
    {
        $this->setupWarehouse();

        $losAngeles = new Entity\Point(34.052234, -118.243685);

        $warehouse = $this->warehouseRepository->findByPoint($losAngeles, 1);

        $this->assertSame(0, count($warehouse));
    }

    public function testFindByPoint()
    {
        $this->setupWarehouse();

        $losAngeles = new Entity\Point(34.052234, -118.243685);

        $warehouses = $this->warehouseRepository->findByPoint($losAngeles, 50);

        $warehouse = $warehouses[0][0];
        $distance = $warehouses[0]['distance'];

        $this->assertTrue($warehouse instanceof Entity\Warehouse);

        // Correct distance is 14.421 miles.
        // Check scalar distance column is within 5 miles (for Sqlite).
        $this->assertTrue(($distance - 14.421) < 5);
    }
}
