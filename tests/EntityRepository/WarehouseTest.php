<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class WarehouseTest extends Helper\DoctrineTestCase
{
    /* @var Entity\Warehouse */
    protected $warehouse;

    /**
     * @return Warehouse
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Warehouse');
    }

    /**
     * @return Entity\Warehouse
     */
    private function getDummyWarehouse($num)
    {
        $address = new Entity\Address;
        $address->setAttention('John Doe');
        $address->setCompany('Acme Co.');
        $address->setAddress1('123 Any St');
        $address->setAddress2('Ste 3');
        $address->setCity('Santa Monica');
        $address->setState('CA');
        $address->setZip5('90401');
        $address->setZip4('3274');
        $address->setPoint(new Entity\Point(34.010947, -118.490541));

        $warehouse = new Entity\Warehouse;
        $warehouse->setName('Test Warehouse #' . $num);
        $warehouse->setAddress($address);

        return $warehouse;
    }

    private function setupWarehouse()
    {
        $warehouse1 = $this->getDummyWarehouse(1);

        $this->entityManager->persist($warehouse1);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupWarehouse();

        $warehouse = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $warehouse->getId());
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

        $this->assertSame(1, $warehouses[0][0]->getId());

        // Correct distance is 14.421 miles.
        // Check scalar distance column is within 5 miles (for Sqlite).
        $this->assertTrue(($warehouses[0][1] - 14.421) < 5);
    }
}
