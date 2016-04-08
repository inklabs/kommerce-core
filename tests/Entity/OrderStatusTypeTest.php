<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class OrderStatusTypeTest extends EntityTestCase
{
    public function testCreate()
    {
        $this->assertTrue(OrderStatusType::pending()->isPending());
        $this->assertTrue(OrderStatusType::processing()->isProcessing());
        $this->assertTrue(OrderStatusType::partiallyShipped()->isPartiallyShipped());
        $this->assertTrue(OrderStatusType::shipped()->isShipped());
        $this->assertTrue(OrderStatusType::complete()->isComplete());
        $this->assertTrue(OrderStatusType::canceled()->isCanceled());
    }

    public function testGetters()
    {
        $this->assertSame('Pending', OrderStatusType::pending()->getName());
        $this->assertSame('Processing', OrderStatusType::processing()->getName());
        $this->assertSame('Partially Shipped', OrderStatusType::partiallyShipped()->getName());
        $this->assertSame('Shipped', OrderStatusType::shipped()->getName());
        $this->assertSame('Complete', OrderStatusType::complete()->getName());
        $this->assertSame('Canceled', OrderStatusType::canceled()->getName());
    }

    public function testCreateById()
    {
        $this->assertTrue(OrderStatusType::createById(OrderStatusType::PENDING)->isPending());
    }

    public function testCreateByIdThrowsExceptionWhenInvalid()
    {
        $this->setExpectedException(
            InvalidArgumentException::class
        );

        OrderStatusType::createById(999);
    }
}
