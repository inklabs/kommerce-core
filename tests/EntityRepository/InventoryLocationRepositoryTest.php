<?php
namespace inklabs\kommerce\tests\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class InventoryLocationRepositoryTest extends DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Product',
        'kommerce:InventoryLocation',
        'kommerce:Warehouse',
    ];

    /** @var InventoryLocationRepositoryInterface */
    protected $inventoryLocationRepository;

    public function setUp()
    {
        parent::setUp();
        $this->inventoryLocationRepository = $this->getRepositoryFactory()->getInventoryLocationRepository();
    }

    private function setupInventoryLocation()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $this->entityManager->persist($warehouse);
        $this->entityManager->flush();

        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        return $inventoryLocation;
    }

    public function testCRUD()
    {
        $inventoryLocation = $this->setupInventoryLocation();

        $this->inventoryLocationRepository->create($inventoryLocation);
        $this->assertSame(1, $inventoryLocation->getId());

        $inventoryLocation->setName('New name');
        $this->assertSame(null, $inventoryLocation->getUpdated());
        $this->inventoryLocationRepository->update($inventoryLocation);
        $this->assertTrue($inventoryLocation->getUpdated() instanceof DateTime);

        $this->inventoryLocationRepository->delete($inventoryLocation);
        $this->assertSame(null, $inventoryLocation->getId());
    }

    public function testFindOneById()
    {
        $inventoryLocation = $this->setupInventoryLocation();
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $this->setCountLogger();

        $inventoryLocation = $this->inventoryLocationRepository->findOneById(1);

        $this->assertSame(1, $this->getTotalQueries());
        $this->assertTrue($inventoryLocation instanceof InventoryLocation);
        $this->assertSame('Widget Bin', $inventoryLocation->getName());
        $this->assertSame('Z1-A13-B37-L5-P3', $inventoryLocation->getCode());
        $this->assertTrue($inventoryLocation->getWarehouse() instanceof Warehouse);
    }

    public function testFindOneByIdThrowsNotFoundException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'InventoryLocation not found'
        );

        $this->inventoryLocationRepository->findOneById(1);
    }
}
