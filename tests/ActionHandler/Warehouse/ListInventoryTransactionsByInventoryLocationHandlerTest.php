<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Warehouse\ListInventoryTransactionsByInventoryLocationQuery;
use inklabs\kommerce\ActionResponse\Warehouse\ListInventoryTransactionsByInventoryLocationResponse;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListInventoryTransactionsByInventoryLocationHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Product::class,
        Tag::class,
        Warehouse::class,
        InventoryLocation::class,
        InventoryTransaction::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation1 = $this->dummyData->getInventoryLocation($warehouse);
        $inventoryLocation2 = $this->dummyData->getInventoryLocation($warehouse);
        $inventoryTransaction1 = $this->dummyData->getInventorytransaction($inventoryLocation1, $product);
        $inventoryTransaction2 = $this->dummyData->getInventorytransaction($inventoryLocation1, $product);
        $inventoryTransaction3 = $this->dummyData->getInventorytransaction($inventoryLocation2, $product);
        $this->persistEntityAndFlushClear([
            $product,
            $warehouse,
            $inventoryLocation1,
            $inventoryLocation2,
            $inventoryTransaction1,
            $inventoryTransaction2,
            $inventoryTransaction3,
        ]);
        $query = new ListInventoryTransactionsByInventoryLocationQuery(
            $inventoryLocation1->getId()->getHex(),
            new PaginationDTO()
        );

        /** @var ListInventoryTransactionsByInventoryLocationResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEntitiesInDTOList(
            [
                $inventoryTransaction1,
                $inventoryTransaction2,
            ],
            $response->getInventoryTransactionDTOs()
        );
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
