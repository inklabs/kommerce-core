<?php
namespace inklabs\kommerce\ActionHandler\Option;

use inklabs\kommerce\Action\Warehouse\DeleteInventoryLocationCommand;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteInventoryLocationHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
        InventoryLocation::class,
    ];

    public function testHandle()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $this->persistEntityAndFlushClear([
            $warehouse,
            $inventoryLocation,
        ]);
        $command = new DeleteInventoryLocationCommand($inventoryLocation->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getInventoryLocationRepository()->findOneById(
            $inventoryLocation->getId()
        );
    }
}
