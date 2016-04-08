<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AbstractPaymentTest extends EntityTestCase
{
    public function testCreate()
    {
        $orderItem = new OrderItem;
        $orderItem->setProduct(new Product);
        $orderItem->setQuantity(1);
        $orderItem->setPrice(new Price);

        $order = new Order;
        $order->addOrderItem($orderItem);
        $order->setTotal(new CartTotal);

        /** @var $mock AbstractPayment */
        $mock = $this->getMockForAbstractClass(AbstractPayment::class);
        $mock->setAmount(100);
        $mock->setOrder($order);

        $this->assertEntityValid($mock);
        $this->assertSame(100, $mock->getAmount());
        $this->assertTrue($mock->getOrder() instanceof Order);
    }
}
