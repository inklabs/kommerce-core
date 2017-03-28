<?php
namespace inklabs\kommerce\Entity;

use DateTime;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class InventoryTransactionTest extends EntityTestCase
{
    public function testCreateDefaults()
    {
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $product = $this->dummyData->getProduct();
        $quantity = 2;
        $inventoryTransaction = InventoryTransaction::credit(
            $product,
            $quantity,
            'memo',
            $inventoryLocation,
            InventoryTransactionType::move()
        );

        $this->assertEntitiesEqual($inventoryLocation, $inventoryTransaction->getInventoryLocation());
        $this->assertEntitiesEqual($product, $inventoryTransaction->getProduct());
        $this->assertSame($quantity, $inventoryTransaction->getQuantity());
        $this->assertSame('memo', $inventoryTransaction->getMemo());
        $this->assertTrue($inventoryTransaction->getType()->isMove());
    }

    public function testCreateDebitTransaction()
    {
        $inventoryLocation = $this->dummyData->getInventoryLocation();
        $inventoryTransactionType = $this->dummyData->getInventoryTransactionType();
        $product = $this->dummyData->getProduct();

        $inventoryTransaction = InventoryTransaction::debit(
            $product,
            5,
            'Test memo',
            $inventoryLocation,
            $inventoryTransactionType
        );

        $this->assertEntityValid($inventoryTransaction);
        $this->assertSame(-5, $inventoryTransaction->getQuantity());
        $this->assertSame('Test memo', $inventoryTransaction->getMemo());
        $this->assertSame($inventoryLocation, $inventoryTransaction->getInventoryLocation());
        $this->assertSame($product, $inventoryTransaction->getProduct());
        $this->assertSame($inventoryTransactionType, $inventoryTransaction->getType());
    }

    public function testPickAndShipTransaction()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $product = $this->dummyData->getProduct();
        $widgetBin = new InventoryLocation($warehouse, 'Widget Bin', 'Z1-A13-B37-L5-P3');
        $customerLocation = new InventoryLocation($warehouse, 'Shipped to Customer', 'SHIP');

        $pickTransaction = InventoryTransaction::debit(
            $product,
            2,
            'Picked 2 Widgets',
            $widgetBin
        );

        $shipTransaction = InventoryTransaction::credit(
            $product,
            2,
            'Shipped 2 Widgets to customer',
            $customerLocation
        );

        $this->assertEntityValid($pickTransaction);
        $this->assertEntityValid($shipTransaction);
        $this->assertTrue($pickTransaction->getInventoryLocation() instanceof InventoryLocation);
        $this->assertTrue($pickTransaction->getProduct() instanceof Product);
        $this->assertTrue($pickTransaction->getCreated() instanceof DateTime);
        $this->assertSame(-2, $pickTransaction->getQuantity());
        $this->assertSame('Picked 2 Widgets', $pickTransaction->getMemo());
        $this->assertTrue($pickTransaction->getType()->isMove());

        $this->assertSame(2, $shipTransaction->getQuantity());
    }

    protected function assertInvalidQuantity(InventoryTransaction $inventoryTransaction)
    {
        $errors = $this->getValidationErrors($inventoryTransaction);

        $this->assertSame(2, count($errors));
        $this->assertSame('debitQuantity', $errors->get(0)->getPropertyPath());
        $this->assertSame('Only DebitQuantity or CreditQuantity should be set', $errors->get(0)->getMessage());

        $this->assertSame('creditQuantity', $errors->get(1)->getPropertyPath());
        $this->assertSame('Only DebitQuantity or CreditQuantity should be set', $errors->get(1)->getMessage());
    }

    public function testHoldInventoryForOrderShipment()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $product = $this->dummyData->getProduct();

        $widgetBinLocation = $this->dummyData->getInventoryLocation($warehouse);
        $debitTransaction = InventoryTransaction::debit(
            $product,
            2,
            'Hold 2 Widgets for order #123',
            $widgetBinLocation,
            InventoryTransactionType::hold()
        );

        $customerHoldingLocation = new InventoryLocation($warehouse, 'Reserve for Customer', 'HOLD');
        $creditTransaction = InventoryTransaction::credit(
            $product,
            2,
            'Hold 2 Widgets for order #123',
            $customerHoldingLocation,
            InventoryTransactionType::hold()
        );

        $this->assertEntityValid($debitTransaction);
        $this->assertEntityValid($creditTransaction);
        $this->assertTrue($debitTransaction->getType()->isHold());
    }

    public function testMoveInventoryBetweenLocations()
    {
        $warehouse = $this->dummyData->getWarehouse();
        $product = $this->dummyData->getProduct();
        $sourceLocation = new InventoryLocation($warehouse, 'Source Location', 'S1');
        $destinationLocation = new InventoryLocation($warehouse, 'Destination Location', 'D1');

        $debitTransaction = InventoryTransaction::debit(
            $product,
            2,
            'Move 2 Widgets',
            $sourceLocation
        );

        $creditTransaction = InventoryTransaction::credit(
            $product,
            2,
            'Move 2 Widgets',
            $destinationLocation
        );

        $this->assertEntityValid($debitTransaction);
        $this->assertEntityValid($creditTransaction);
    }
}
