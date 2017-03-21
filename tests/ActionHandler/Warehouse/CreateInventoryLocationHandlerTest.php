<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\CreateInventoryLocationCommand;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateInventoryLocationHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
        InventoryLocation::class,
    ];

    public function testHandle()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $this->persistEntityAndFlushClear($warehouse);
        $name = 'Zone 1 | Bin 2';
        $code = 'Z1-B2';
        $command = new CreateInventoryLocationCommand(
            $warehouse->getId()->getHex(),
            $name,
            $code
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
