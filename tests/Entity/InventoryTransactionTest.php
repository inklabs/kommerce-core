<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class InventoryTransactionTest extends DoctrineTestCase
{
    public function testCreate()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $widgetBin = new InventoryLocation($warehouse, 'Widget Bin', 'Z1-A13-B37-L5-P3');
        $customerLocation = new InventoryLocation($warehouse, 'Shipped to Customer', 'SHP');

        $pickTransaction = new InventoryTransaction($widgetBin);
        $pickTransaction->setDebitQuantity(2);
        $pickTransaction->setMemo('Picked 2 Widgets');

        $shipTransaction = new InventoryTransaction($customerLocation);
        $shipTransaction->setCreditQuantity(2);
        $shipTransaction->setMemo('Shipped 2 Widgets to customer');

        $this->assertEntityValid($pickTransaction);
        $this->assertTrue($pickTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($pickTransaction->getCreated() instanceof DateTime);
        $this->assertSame(2, $pickTransaction->getDebitQuantity());
        $this->assertSame(null, $pickTransaction->getCreditQuantity());
        $this->assertSame('Picked 2 Widgets', $pickTransaction->getMemo());

        $this->assertSame(null, $shipTransaction->getDebitQuantity());
        $this->assertSame(2, $shipTransaction->getCreditQuantity());
    }

    public function testDebitOrCreditMustNotBeNull()
    {
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $inventoryTransaction = new InventoryTransaction($inventoryLocation);
        $inventoryTransaction->setDebitQuantity(null);
        $inventoryTransaction->setCreditQuantity(null);
        $inventoryTransaction->setMemo('Failed Transaction');

        $errors = $this->getValidationErrors($inventoryTransaction);

        $this->assertSame(2, count($errors));
        $this->assertSame('debitQuantity', $errors->get(0)->getPropertyPath());
        $this->assertSame('Both DebitQuantity and CreditQuantity should not be null', $errors->get(0)->getMessage());

        $this->assertSame('creditQuantity', $errors->get(1)->getPropertyPath());
        $this->assertSame('Both DebitQuantity and CreditQuantity should not be null', $errors->get(1)->getMessage());
    }
}
