<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class AbstractPaymentTest extends EntityTestCase
{
    public function testCreate()
    {
        $order = $this->dummyData->getOrder();

        /** @var $mock AbstractPayment */
        $mock = $this->getMockForAbstractClass(AbstractPayment::class);
        $mock->setAmount(100);
        $mock->setOrder($order);

        $this->assertEntityValid($mock);
        $this->assertSame(100, $mock->getAmount());
        $this->assertTrue($mock->getOrder() instanceof Order);
    }
}
