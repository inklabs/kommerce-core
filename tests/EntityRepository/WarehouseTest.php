<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class WarehouseTest extends Helper\DoctrineTestCase
{
    /**
     * @return Warehouse
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Warehouse');
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

        $warehouse = $this->getRepository()
            ->find(1);

        $this->assertTrue($warehouse instanceof Entity\Warehouse);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }

    public function testFindByPointNotInRange()
    {
        $this->setupWarehouse();

        $losAngeles = new Entity\Point(34.052234, -118.243685);

        $warehouse = $this->getRepository()
            ->findByPoint($losAngeles, 1);

        $this->assertSame(0, count($warehouse));
    }

    public function testFindByPoint()
    {
        $this->setupWarehouse();

        $losAngeles = new Entity\Point(34.052234, -118.243685);

        $warehouses = $this->getRepository()
            ->findByPoint($losAngeles, 50);

        $warehouse = $warehouses[0][0];
        $distance = $warehouses[0]['distance'];

        $this->assertTrue($warehouse instanceof Entity\Warehouse);

        // Correct distance is 14.421 miles.
        // Check scalar distance column is within 5 miles (for Sqlite).
        $this->assertTrue(($distance - 14.421) < 5);
    }
}
