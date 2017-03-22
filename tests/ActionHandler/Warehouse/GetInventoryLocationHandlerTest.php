<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\GetInventoryLocationQuery;
use inklabs\kommerce\ActionResponse\Warehouse\GetInventoryLocationResponse;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetInventoryLocationHandlerTest extends ActionTestCase
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
        $query = new GetInventoryLocationQuery($inventoryLocation->getId()->getHex());

        /** @var GetInventoryLocationResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($inventoryLocation->getId(), $response->getInventoryLocationDTO()->id);
    }
}
