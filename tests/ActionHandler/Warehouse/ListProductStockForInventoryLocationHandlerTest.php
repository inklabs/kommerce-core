<?php
namespace inklabs\kommerce\ActionHandler\Shipment;

use inklabs\kommerce\Action\Warehouse\ListProductStockForInventoryLocationQuery;
use inklabs\kommerce\ActionResponse\Warehouse\ListProductStockForInventoryLocationResponse;
use inklabs\kommerce\DTO\ProductStockDTO;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class ListProductStockForInventoryLocationHandlerTest extends ActionTestCase
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
        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation1 = $this->dummyData->getInventoryLocation($warehouse);
        $inventoryLocation2 = $this->dummyData->getInventoryLocation($warehouse);
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $product3 = $this->dummyData->getProduct();
        $inventoryTransaction1 = $this->dummyData->getInventoryTransaction($inventoryLocation1, $product1, 2);
        $inventoryTransaction2 = $this->dummyData->getInventoryTransaction($inventoryLocation1, $product2, 2);
        $inventoryTransaction3 = $this->dummyData->getInventoryTransaction($inventoryLocation2, $product3, 2);
        $inventoryTransaction4 = InventoryTransaction::debit($product2, 1, 'breakage', $inventoryLocation1);
        $this->persistEntityAndFlushClear([
            $warehouse,
            $inventoryLocation1,
            $inventoryLocation2,
            $product1,
            $product2,
            $product3,
            $inventoryTransaction1,
            $inventoryTransaction2,
            $inventoryTransaction3,
            $inventoryTransaction4,
        ]);
        $query = new ListProductStockForInventoryLocationQuery(
            $inventoryLocation1->getId()->getHex(),
            new PaginationDTO()
        );

        /** @var ListProductStockForInventoryLocationResponse $response */
        $response = $this->dispatchQuery($query);

        /** @var ProductStockDTO[] $productStockDTOs */
        $productStockDTOs = iterator_to_array($response->getProductStockDTOs());
        $this->assertEquals($product1->getId(), $productStockDTOs[0]->getProductDTO()->id);
        $this->assertEquals($product2->getId(), $productStockDTOs[1]->getProductDTO()->id);
        $this->assertEquals(2, $productStockDTOs[0]->getQuantity());
        $this->assertEquals(1, $productStockDTOs[1]->getQuantity());
        $this->assertTrue($response->getPaginationDTO() instanceof PaginationDTO);
    }
}
