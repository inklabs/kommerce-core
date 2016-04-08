<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class InventoryTransactionDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $inventoryTransaction = $this->dummyData->getInventoryTransaction();

        $inventoryTransactionDTO = $inventoryTransaction->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($inventoryTransactionDTO instanceof InventoryTransactionDTO);
        $this->assertTrue($inventoryTransactionDTO->product instanceof ProductDTO);
        $this->assertTrue($inventoryTransactionDTO->type instanceof InventoryTransactionTypeDTO);
        $this->assertTrue($inventoryTransactionDTO->inventoryLocation instanceof InventoryLocationDTO);
    }
}
