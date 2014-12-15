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
        $address->setLatitude(34.010947);
        $address->setLongitude(-118.490541);

        $warehouse = new Entity\Warehouse;
        $warehouse->setName('Test Warehouse #' . $num);
        $warehouse->setAddress($address);

        return $warehouse;
    }

    public function testFind()
    {
        $warehouse1 = $this->getDummyWarehouse(1);

        $this->entityManager->persist($warehouse1);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $warehouse = $this->getRepository()
            ->find(1);

        $this->assertEquals(1, $warehouse->getId());
    }
}
