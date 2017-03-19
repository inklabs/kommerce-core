<?php
namespace inklabs\kommerce\ActionHandler\Warehouse;

use inklabs\kommerce\Action\Warehouse\GetWarehouseQuery;
use inklabs\kommerce\ActionResponse\Warehouse\GetWarehouseResponse;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetWarehouseHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
    ];

    public function testHandle()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $this->persistEntityAndFlushClear($warehouse);
        $query = new GetWarehouseQuery($warehouse->getId()->getHex());

        /** @var GetWarehouseResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($warehouse->getId(), $response->getWarehouseDTO()->id);
    }
}
