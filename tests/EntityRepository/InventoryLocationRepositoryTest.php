<?php
namespace inklabs\kommerce\tests\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\InventoryLocationRepositoryInterface;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class InventoryLocationRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        InventoryLocation::class,
        Warehouse::class,
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
        $warehouse = $this->dummyData->getWarehouse();
        $this->entityManager->persist($warehouse);
        $this->entityManager->flush();

        $this->executeRepositoryCRUD(
            $this->inventoryLocationRepository,
            $this->dummyData->getInventoryLocation($warehouse)
        );
    }

    public function testFindOneById()
    {
        $originalInventoryLocation = $this->setupInventoryLocation();
        $this->persistEntityAndFlushClear($originalInventoryLocation);
        $this->setCountLogger();

        $inventoryLocation = $this->inventoryLocationRepository->findOneById(
            $originalInventoryLocation->getId()
        );

        $this->assertTrue($inventoryLocation instanceof InventoryLocation);
        $this->assertSame('Widget Bin', $inventoryLocation->getName());
        $this->assertSame('Z1-A13-B37-L5-P3', $inventoryLocation->getCode());
        $this->assertTrue($inventoryLocation->getWarehouse() instanceof Warehouse);
        // TODO: Compare $originalInventoryLocation->getWarehouse()->getId()
        // TODO: to $inventoryLocation->getWarehouse()->getId()
        // TODO: for query performance optimization
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsNotFoundException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'InventoryLocation not found'
        );

        $this->inventoryLocationRepository->findOneById(
            $this->dummyData->getId()
        );
    }
}
