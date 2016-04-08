<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class InventoryTransactionTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(InventoryTransactionType::move()->isMove());
        $this->assertTrue(InventoryTransactionType::hold()->isHold());
        $this->assertTrue(InventoryTransactionType::newProducts()->isNewProducts());
        $this->assertTrue(InventoryTransactionType::shipped()->isShipped());
        $this->assertTrue(InventoryTransactionType::returned()->isReturned());
        $this->assertTrue(InventoryTransactionType::promotion()->isPromotion());
        $this->assertTrue(InventoryTransactionType::damaged()->isDamaged());
        $this->assertTrue(InventoryTransactionType::shrinkage()->isShrinkage());
    }

    public function testGetters()
    {
        $this->assertSame('Move', InventoryTransactionType::move()->getName());
        $this->assertSame('Hold', InventoryTransactionType::hold()->getName());
        $this->assertSame('New Products', InventoryTransactionType::newProducts()->getName());
        $this->assertSame('Shipped', InventoryTransactionType::shipped()->getName());
        $this->assertSame('Returned', InventoryTransactionType::returned()->getName());
        $this->assertSame('Promotion', InventoryTransactionType::promotion()->getName());
        $this->assertSame('Damaged', InventoryTransactionType::damaged()->getName());
        $this->assertSame('Shrinkage', InventoryTransactionType::shrinkage()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(InventoryTransactionType::createById(InventoryTransactionType::MOVE)->isMove());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        InventoryTransactionType::createById(999);
    }
}
