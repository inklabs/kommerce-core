<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Warehouse\ListWarehousesQuery;
use inklabs\kommerce\ActionResponse\Warehouse\ListWarehousesResponse;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListWarehousesHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Warehouse::class,
    ];

    public function testHandle()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $this->persistEntityAndFlushClear($warehouse);
        $queryString = 'Warehouse';
        $query = new ListWarehousesQuery($queryString, new PaginationDTO());

        /** @var ListWarehousesResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntitiesInDTOList([$warehouse], $response->getWarehouseDTOs());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
