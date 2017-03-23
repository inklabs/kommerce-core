<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\UpdateInventoryLocationCommand;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class UpdateInventoryLocationHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
        InventoryLocation::class,
    ];

    public function testHandle()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);
        $this->persistEntityAndFlushClear([$warehouse, $inventoryLocation]);
        $name = 'New Name';
        $code = 'NC';
        $command = new UpdateInventoryLocationCommand(
            $name,
            $code,
            $inventoryLocation->getId()->toString()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $inventoryLocation = $this->getRepositoryFactory()->getInventoryLocationRepository()->findOneById(
            $command->getInventoryLocationId()
        );
        $this->assertSame($name, $inventoryLocation->getName());
        $this->assertSame($code, $inventoryLocation->getCode());
    }
}
